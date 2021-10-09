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
use Coinbase\Wallet\Resource\Transaction;
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
            // dd($subscribers);
            return view('backend.admin.index', compact('medals','subscribers', 'tasks', 'subscribers' ,'withdraw_request', 'pending_requests', 'plans', 'title' ));
        }

        if(auth()->user()->user_types == 1){
            $title = 'User Dashboard';
            if(auth()->user()->plans->count() < 1){
                return view('backend.user.selectplans', compact('title'));
            }
           
            return view('backend.user.index')->with(['title' => $title]);
        }
        
    }

    public function payment(Request $request){
        
//        dd($request->all());
//         $configuration = Configuration::apiKey(env('COINBASE_API_KEY'), env('COINBASE_WEBHOOK_SECRET'));
//         $client = Client::create($configuration);

//         $order = new Order([
//             'name' => 'Order #1234',
//             'amount' => Money::btc(1)
//         ]);
        
//         $client->createOrder($order);

        
//         dd('sd');
        
        
       
        
//         // or use the convenience method
//         // $deposit = new Deposit([
//         //     'paymentMethodId' => $paymentMethodId
//         // ]);

       
//         $ch = curl_init();
//         curl_setopt($ch, CURLOPT_URL, "curl https://api.coinbase.com/v2/user -H 'Authorization: Bearer d57fb2a790e440aec463d4a03ffc02e7117c33800d67afe5624fb03edd148c32'");
        
        
//         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//         // $prices = json_decode(curl_exec($ch), true);
//         curl_close($ch);


//         // $ch = curl_init();
//         // curl_setopt($ch, CURLOPT_URL, "https://api.coinbase.com/v2/notifications \
//         // -H 'Authorization: Bearer cfce1be2-2f48-4383-9166-3265cdcacdc3'");
//         // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//         // $prices = json_decode(curl_exec($ch), true);
//         // curl_close($ch);


// //         curl https://api.coinbase.com/v2/user /
// //   -H 'Authorization: Bearer 6915ab99857fec1e6f2f6c078583756d0c09d7207750baea28dfbc3d4b0f2cb80'
//         dd($prices);

    }


    public function paymentpost(Request $request){
      
    }
    public function savePlan(Request $request){

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "curl https://api.coinbase.com/v2/user -H 'Authorization: Bearer d57fb2a790e440aec463d4a03ffc02e7117c33800d67afe5624fb03edd148c32");
        
        
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $prices = json_decode(curl_exec($ch), true);
        curl_close($ch);
        

        $params = array(
            'name'               => 'My Order',
            'amount'             => new Money(100, 'USD'),
            // 'metadata'           => array( 'order_id' => $custom_order_id )
        );
        
        $configuration = Configuration::apiKey(env('COINBASE_API_KEY'), env('COINBASE_WEBHOOK_SECRET'));
        $client = Client::create($configuration);

        
        $checkout = new Checkout($params);
        
        $client->createCheckout($checkout);
        // dd($checkout);
        $code = $checkout->getEmbedCode();
        $order = $client->createNewCheckoutOrder($checkout);
        dd($order);
        $redirect_url = "https://www.coinbase.com/checkouts/$code";     
       
        auth()->user()->update([
            'publishing_plans_id' => $request->plan,
            'plan_expiry' => $plan_expiry,
        ]);

        return redirect(route('profile.billing'))->with('message', 'Subscription Successsful');
    }

    public function promote(){

        if(auth()->user()->wallet_address == NULL || auth()->user()->eth_wallet_address == NULL || auth()->user()->ltc_wallet_address == NULL || auth()->user()->bnb_wallet_address == NULL || auth()->user()->phone == NULL){
            return redirect(route('profile.edit', auth()->user()->id))->with('error', 'You must update your details first');
        }
        return view('backend.user.index');
    }


    public function selectplans(){
        $plans = publishing_plans::all();

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.commerce.coinbase.com/charges',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'X-CC-Api-Key: 289d349d-831d-4d2a-99fa-012db1dadb03',
            'Cookie: __cfduid=db701e704100840bad156cdfdc957b7ae1616524238; amplitude_device_id=f1103d1d-59eb-4137-b39a-336c6ca6005f; coinbase_device_id=f1103d1d-59eb-4137-b39a-336c6ca6005f'
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $jsonresponse = json_decode($response);
       
        foreach ($jsonresponse->data as $data) {
            if (strtolower($data->metadata->email) == strtolower(auth()->user()->email)) {
                # echo 'you tried to pay<br>';
                # check for payments
                if (empty($data->payments)) {
                    $title = 'Purchase plan';
            
                    return redirect(url('/selectplans'));
                }else{
                    # echo 'you paid<br>';
                    foreach ($data->payments as $paymentdata) {
                        # show status
                        if ($paymentdata->status == 'PENDING') {
                            $plans = publishing_plans::all();
                            $paymentmessage = 'Your Payment for your publishing plan is pending. Continue to refresh this page to the current status of your payment. You would also be notified via email when your payment has been confirmed';
                            $paymentstatus = $paymentdata->status;
                            // echo 'transaction is '.$paymentdata->status;
                            return view('backend.user.selectplans', compact('plans','paymentmessage','paymentstatus'));
                        }elseif($paymentdata->status == 'CONFIRMED'){
                            # code...
                            # echo 'transaction is '.$paymentdata->status;
                            # get the title of the payment
                            if (publishing_plans::where('title','=',$data->name)) {
                                # the publishing plan exists now check for the publishing plan amount and check with the amount paid
                                $pubplan = publishing_plans::where('title','=',$data->name)->first();
                                if ($pubplan->amount == $paymentdata->value->local->amount) {
                                    # if the amount is the same update user publishing plan
                                    $user = User::findOrFail(auth()->user()->id); 
                                    $user->publishing_plans_id = $pubplan->id;
                                    $user->plan_expiry = Carbon::now()->addMonth(1);
                                    $user->save();
                                    // echo 'transaction is perfect your publishing plan has been updated';
        
                                    //Update upline referral bonus here
                                    $this->updateReferral($pubplan); 
        
                                    Mail::to($user->email)->send(new paymentComplete($user, $data->name, $paymentdata->value->local->amount));
                                    Mail::to(Setting::select('official_mail')->first()->value('official_mail'))->send(new paymentComplete($user, $data->name, $paymentdata->value->local->amount));
                                    
                                    return redirect()->route('dashboard');
                                }elseif ($pubplan->amount < $paymentdata->value->local->amount) {
                                   
                                    $overpaymentbalance = $paymentdata->value->local->amount - $pubplan->amount;
                                    $user = User::findOrFail(auth()->user()->id);
                                    # add the balance to the wallet and update the users publishing plan
                                    $user->wallet_balance = $user->wallet_balance + $overpaymentbalance;
                                    $user->publishing_plans_id = $pubplan->id;
                                    $user->save();
                                    
                                    return redirect()->route('dashboard');
        
                                    # echo 'transaction is overpaid but publishing plan is updated';
                                    Mail::to($user->email)->send(new paymentComplete($user, $data->name, $paymentdata->value->local->amount, $overpaymentbalance));
                                }elseif ($pubplan->amount > $paymentdata->value->local->amount) {
                                    
                                    $paymentmessage = 'Your payment was recieved but you made an underpayment. Kindly contact the admin to get a new link to complete your balance';
                                    return view('backend.user.selectplans', compact('plans','paymentmessage'));
        
                                    // echo 'transaction is underpayment. contact admin';
        
                                    return redirect()->route('dashboard');
                                    
                                }
                            }
                        }
                    }
                }
            }
        }
        
        return view('backend.user.selectplans', compact('plans'));
    }

   

    public function newPromotion($media){
        $user_done_tasks = [];
        
        $done_tasks = auth()->user()->tasks;

        //Check if user has performed any task today
        $task_history = auth()->user()->completedTasks();
        if($task_history > 0){
            return back()->with('error', 'You cannot attempt more than one promotion per day!');
        }
    
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
        //Mark task as complete
        
        // dd($this->task);
        auth()->user()->tasks()->attach($task->id, [
            'initiated' => 1,
            'created_at' =>  date("Y-m-d H:i:s"),
            'updated_at' =>  date("Y-m-d H:i:s"),
        ] );
      
        
        UpdateUserWallet::dispatch(Auth::user()->id)
                    ->delay(now()->addMinutes(1));


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

    public function test(){
        $charge = Coinbase::createCharge([
            'name' => 'Name',
            'description' => 'Description',
            'local_price' => [
                'amount' => 100,
                'currency' => 'USD',
            ],
            'metadata' => [
                'user_id' => auth()->user()->id,
                'email' => auth()->user()->email,
            ],
            'pricing_type' => 'fixed_price',
        ]);

        $charges = Coinbase::getCharges();
        dd($charges);
        return redirect()->away($charge['data']['hosted_url']);

}

public function c(){
    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.commerce.coinbase.com/charges',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'X-CC-Api-Key: 289d349d-831d-4d2a-99fa-012db1dadb03',
        'Cookie: __cfduid=db701e704100840bad156cdfdc957b7ae1616524238; amplitude_device_id=f1103d1d-59eb-4137-b39a-336c6ca6005f; coinbase_device_id=f1103d1d-59eb-4137-b39a-336c6ca6005f'
    ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    
    return $response;
}
}
