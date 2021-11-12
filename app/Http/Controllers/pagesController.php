<?php

namespace App\Http\Controllers;

use DB;
use auth;
use Carbon\Carbon;
use App\Models\Task;
use App\Models\User;
use App\Models\Medal;
use App\Models\Setting;
use App\Models\Withdrawal;
use App\Models\Transaction;
use Coinbase\Wallet\Client;
use Illuminate\Http\Request;
use App\Mail\paymentComplete;
use App\Jobs\UpdateUserWallet;
use CoinbaseCommerce\ApiClient;
use App\Models\publishing_plans;
use Coinbase\Wallet\Value\Money;
use Coinbase\Wallet\Configuration;
use Coinbase\Wallet\Resource\Order;
use Illuminate\Support\Facades\Mail;
use Coinbase\Wallet\Resource\Deposit;
use Coinbase\Wallet\Enum\CurrencyCode;
use Coinbase\Wallet\Resource\Checkout;
use Shakurov\Coinbase\Facades\Coinbase;
use Illuminate\Support\Facades\Redirect;
// use Coinbase\Wallet\Resource\Transaction;
use Coinbase\Wallet\Resource\PaymentMethod;

class pagesController extends Controller
{
           
    public function index(){
        $title = 'Home Page';
        $plans = publishing_plans::all();

        return view('index')->with(['title' => $title, 'plans' => $plans]);
    }

    public function dashboard(){
        if(auth()->user()->user_types == 2 || auth()->user()->user_types == 3){
            $title = 'Admin Dashboard';
            $subscribers = User::where('user_types', 1)->count();
            $tasks = Task::where('status', 'Publish')->count();
            $withdraw_request = Withdrawal::count();
            $pending_requests = Withdrawal::wherePaid(0)->count();
            $plans = publishing_plans::count(); 
            $medals = Medal::count();
           
            return view('backend.admin.index', compact('medals','subscribers', 'tasks', 'subscribers' ,'withdraw_request', 'pending_requests', 'plans', 'title' ));
        }

        if(auth()->user()->user_types == 1){
            return view('backend.user.index');
        }
        
    }

    public function renew(){

        if (!is_null(auth()->user()->plans) && auth()->user()->user_types == 1 && Carbon::parse(auth()->user()->plan_expiry) >= Carbon::now() ) {
            return redirect(route('dashboard'));
        }

        if (is_null(auth()->user()->plans) ) {
            return redirect(route('dashboard'));
        }

        $status = $this->getStatus(2); //1 - new plan, 2 - renew plan 3 - adverts, 4 - designs
       
        if(!is_null($status)){
            //Check transaction status
            $transactionDetails = collect($this->getTransactionDetails($status->reference));
          
            //There is payment but it is not confirmed
            if(!empty($transactionDetails['payments'])){
                $id = $transactionDetails['id'];
                return redirect(route('confirm.payment', $id));
            }
        }
       
        $plan = auth()->user()->plans;
        return view('backend.user.renewplans', compact('plan'));
    }

    public function select(){

        $plans = publishing_plans::where('id', '!=', auth()->user()->publishing_plans_id)->get();
    
        if (!is_null(auth()->user()->plans) && auth()->user()->user_types == 1 && Carbon::parse(auth()->user()->plan_expiry) >= Carbon::now() ) {
            return redirect(route('dashboard'));
        }

        $status = $this->getStatus(1); //1 - new plan, 2 - renew plan 3 - adverts, 4 - designs
       
        if(!is_null($status)){
            //Check transaction status
            $transactionDetails = collect($this->getTransactionDetails($status->reference));
            //There is payment but it is not confirmed
            if(!empty($transactionDetails['payments'])){
                $id = $transactionDetails['id'];
                return redirect(route('confirm.payment', $id));
            }
        }
        
        return view('backend.user.selectplans', compact('plans'));
    }

    public function selectnew(){
        
        $plans = publishing_plans::where('id', '!=', auth()->user()->publishing_plans_id)->get();
    
        if (!is_null(auth()->user()->plans) && auth()->user()->user_types == 1 && Carbon::parse(auth()->user()->plan_expiry) >= Carbon::now() ) {
            return redirect(route('dashboard'));
        }

        $status = $this->getStatus(2); //1 - new plan, 2 - renew plan 3 - adverts, 4 - designs
       
        if(!is_null($status)){
            //Check transaction status
            $transactionDetails = collect($this->getTransactionDetails($status->reference));
            //There is payment but it is not confirmed
            if(!empty($transactionDetails['payments'])){
                $id = $transactionDetails['id'];
                return redirect(route('confirm.payment', $id));
            }
        }

        $plans = publishing_plans::where('id', '!=', auth()->user()->publishing_plans_id)->get();
        return view('backend.user.selectnewplan', compact('plans'));

    }
    

    public function test(Request $request){
       
       
        $jsonresponse = Coinbase::getCharges();
        // dd($jsonresponse);

        $charge = Coinbase::createCharge([
            'name' => 'Name',
            'description' => 'Description',
            'local_price' => [
                'amount' => 100,
                'currency' => 'USD',
            ],
            'metadata' => [
                'user_id' => auth()->user()->id,
                
            ],

            'pricing_type' => 'fixed_price',
        ]);

        return redirect()->away($charge['data']['hosted_url']);

    }

    public function redirectToGateway(Request $request){
            //delete all user transactions that have not been confirmed over the last 1 day
            $transactionsToDelete = auth()->user()->transactions()->where('status', 'PENDING')->where('created_at', '<', Carbon::now()->subDay(7))->get();
            Transaction::destroy($transactionsToDelete->pluck('id'));
            
            $transaction = auth()->user()->transactions()->where('status', 'PENDING')->where('type', $request->type)->first();
            //if type == 1, i.e. Plan... we dont want multiple payments for a single plan
            if($request->type && ($request->type == 1 || $request->type == 2)){
                $plan = publishing_plans::whereId($request->plan_id)->first();
                $charge = $this->createCharge($plan->title, $plan->amount, auth()->user()->id, $request->type, $request->plan_id, 1);
               
                if(is_null($transaction)){
                    // Create new/
                    $transaction = $this->createTransactionLog(auth()->user()->id, $charge['data']['id'], $plan->amount, 'PENDING', $request->type, json_encode($charge['data']));

                }else{
                    $transaction->reference = $charge['data']['id'];
                    $transaction->save();
                }
            }else{

            }

            return redirect()->away($charge['data']['hosted_url']);

    }

    public function confirmPayment($id){
         //Check payment status and deliver value accordingly
        $transactionDetails = $this->getTransactionDetails($id);

        if(is_null($transactionDetails)){
            return abort(404);
        }

        $status = $transactionDetails['payments'][0]['status'];
          
        //Backward compatibility to payments
        if(!isset($transactionDetails['metadata']['user_id'])){
            $transactionDetails['metadata']['user_id'] = auth()->user()->id;
        }
        if(!isset($transactionDetails['metadata']['plan_id'])){
            $transactionDetails['metadata']['plan_id'] = auth()->user()->plans->id ?? 1;
        }

        if(!isset($transactionDetails['metadata']['type'])){
            $transactionDetails['metadata']['type'] = 2;
        }
        
        //if type is new plan         
        $plan = publishing_plans::whereId($transactionDetails['metadata']['plan_id'])->first();
        $type = $transactionDetails['metadata']['type'];
        if($transactionDetails['payments'][0]['status'] == 'CONFIRMED'){
            $this->processTransaction($plan ?? null, $transactionDetails, $transactionDetails['metadata']['type']);
            
            return view('backend.user.paymentConfirmation', compact('status', 'type'));
        }else{
            return view('backend.user.paymentConfirmation', compact('status', 'type'));
        }        
        
    }
    public function promote(){

        if(auth()->user()->wallet_address == NULL || auth()->user()->eth_wallet_address == NULL || auth()->user()->ltc_wallet_address == NULL || auth()->user()->bnb_wallet_address == NULL || auth()->user()->phone == NULL){
            return redirect(route('profile.edit', auth()->user()->id))->with('error', 'You must update your details first');
        }
        return view('backend.user.index');
    }

    public function newPromotion($media){
        $user_done_tasks = [];
        
        $done_tasks = auth()->user()->tasks;
        
        foreach($done_tasks as $task){
           
            array_push($user_done_tasks, $task->id);
        }
       
        $tasks = Task::where('status', 'Publish')->get();

        foreach($tasks as $key=> $task){
            if(in_array($task->id, $user_done_tasks)){
                $tasks->forget($key);
            }
        }
       
        $task = $tasks->first();
        if(!$task){
            return back()->with('warning', 'You are doing well, no tasks to complete at the moment! Check back later');
        }
  
        //Check if user has performed any task today
        $task_history = auth()->user()->completedTasks();
        if($task_history > 0){
            return back()->with('error', 'You can only share once per day, the system is verifiying status of the promotion you have shared today');
        }
        if($task_history <= 0){
            // dd($this->task);
            auth()->user()->tasks()->attach($task->id, [
                'initiated' => 1,
                'created_at' =>  date("Y-m-d H:i:s"),
                'updated_at' =>  date("Y-m-d H:i:s"),
            ] );
     
            // return back()->with('error', 'You cannot attempt more than one promotion per day!');
            UpdateUserWallet::dispatch(Auth::user()->id)
                ->delay(now()->addMinutes(Setting::first()->value('payment_delay')));
        }

        if($media && $media == 1){ //Share to facebook
            $url = 'https://www.facebook.com/sharer/sharer.php?u='.$task->posturl.'&display=popup&target=_blank';
        }
        
        if($media && $media == 2){ 
            $url = 'https://wa.me/?text='.$task->posturl.'&display=popup&target=_blank';
        }
        return Redirect::away($url);
        
    }
   
    public function mymedals(){

        // return view('admin.backend.index');

    }

   private function getStatus($type){
    $userTransaction = auth()->user()->transactions->where('type', $type)->where('status', 'PENDING')->first();
    return $userTransaction;
   }

}
