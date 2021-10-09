<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Medal;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use App\Models\publishing_plans;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count = 1;
        $users = User::whereUserTypes(1)->with('plans', 'upline', 'tasks')->orderby('created_at', 'DESC')->get();
        
        return view('backend.admin.users.index', compact('count', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $plans = publishing_plans::all();

        return view('backend.admin.users.create', compact('plans'));
    }

    public function store(Request $request)
    {
  
        $data = $this->validate($request, [
            'name' => 'required|string|max:255',
            'username' => 'string|unique:users',
            'phone' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'nullable|string|min:8|confirmed',
            'my_referral' => 'nullable|string|unique:users',

        ]);

         //Handle Password
        if ($request['password']) {
            $password = Hash::make($request['password']);
        }else{
            $password = Hash::make($request['Earnkrypt2000']);
        }
       
        //handle referral
        if(isset($data['my_referral'])){
            $my_referral = User::select('id', 'my_upline')->whereMyReferralCode($data['my_referral'])->value('id');
        }else{
            $my_referral = User::select('id')->whereUserTypes('3')->value('id'); 
        }

        $user = User::create([
            'name' => $data['name'],
            'my_upline' => isset($my_referral) ? $my_referral : NULL,
            'phone' => $data['phone'],
            'email' => $data['email'],
            'username' => $data['username'],
            'my_referral_code' => $data['username'],
            'password' => $password,
            'user_types' => 1,
         ]);

        return redirect(route('user.index'))->with('message', 'Subscriber successfully added');
    
    }

    public function show($id)
    {
        //
    }

    public function edit(User $user)
    {
        $plans = publishing_plans::all();
        return view('backend.admin.users.update', compact('user', 'plans'));
      
    }


    public function update(Request $request, User $user)
    {
        //Handle Password
        if ($request['password']) {
            $request['password'] = Hash::make($request['password']);
        }else{
            $request['password'] = $user->password;
        }

        $user->update($request->all());

        return back()->with('message', 'Update successfull');
    }

    public function destroy(Request $request, $id)
    {
        
        $user = User::find($id);

        if (file_exists($user->avatar))
        unlink($user->avatar);

        $user->delete();

        return back()->with('message', 'Delete successful');
    }

    public function editProfile($id){
        $user = auth()->user();
        
        if(auth()->user()->user_types == 2 || auth()->user()->user_types == 3){
            return view('backend.admin.profile', compact('user'));
        }

        if(auth()->user()->user_types == 1 ){
            return view('backend.user.profile', compact('user'));
        }
    }

    public function saveProfile(Request $request){
        // dd($request->all());
        $user = auth()->user();
        $data = $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'unique:users,email,'.$user->id,
            'avatar' => 'nullable|max:1024',
            'wallet_address' => 'required',
            'eth_wallet_address' => 'required',
            'ltc_wallet_address' =>'required',
            'bnb_wallet_address' => 'required'
        ]);

        // Handle avatar upload
       if($request->has('avatar')){
            //Unlink previous image
            if($user->avatar){
                if (file_exists(base_path() . '/uploads'.'/'.$user->avatar))
                unlink(base_path() . '/uploads'.'/'. $user->avatar);
            }
            
            $filename = date('d-M-Y-s') . '-'. pathinfo($request->avatar->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $request->avatar->getClientOriginalExtension();                 
            $user->avatar = $request->avatar->storeAs('avatars', $filename.'.'.$extension,'uploads'); 
   
        }

        $user->name = $data['name'];
        $user->phone = $data['phone'];
        $user->email = $data['email'];
        $user->wallet_address = $data['wallet_address'];
        $user->eth_wallet_address = $data['eth_wallet_address'];
        $user->ltc_wallet_address = $data['ltc_wallet_address'];
        $user->bnb_wallet_address = $data['bnb_wallet_address'];

        $user->save();
               
        return back()->with('message', 'Update successful');

    }

    public function editSecurityProfile(){
        $user = auth()->user();
        
        if(auth()->user()->user_types == 2 || auth()->user()->user_types == 3){
            return view('sds', compact('user'));
        }

        if(auth()->user()->user_types == 1 ){
            return view('backend.user.security', compact('user'));
        }
    }

    public function saveSecurityProfile(Request $request){
        if (Hash::check($request->oldpassword, auth()->user()->password))
        {
            $password = Hash::make($request->newpassword);
            return back()->with('message', 'Password changed succesffuly');
        }else{
            return back()->with('warning', 'looks like your old password is not correct');
        }
    }


    public function editBillingProfile(){
        if(auth()->user()->user_types == 1 ){
            $user = auth()->user();
            return view('backend.user.billing', compact('user'));

        }
    }

     public function saveBillingProfile(Request $request){
       
        $user = auth()->user();
        $data = $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'unique:users,email,'.$user->id,
            'avatar' => 'nullable|max:1024',
            
        ]);

        // Handle avatar upload
       if($request->has('avatar')){
            //Unlink previous image
            if (file_exists(base_path() . '/uploads'.'/'.$user->avatar))unlink(base_path() . '/uploads'.'/'. $user->avatar);
            // unlink( base_path() . '/uploads'.'/'. $user->avatar);

            $filename = date('d-M-Y-s') . '-'. pathinfo($request->avatar->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $request->avatar->getClientOriginalExtension();                 
            $user->avatar = $request->avatar->storeAs('avatars', $filename.'.'.$extension,'uploads'); 

            $user->name = $data['name'];
            $user->phone = $data['phone'];
            $user->email = $data['email'];

            $user->save();

        }

        return back()->with('message', 'Update successful');

    }

    public function getMedals(){
        if(auth()->user()->user_types == 1){
            $medals = Medal::with('users')->get();
            foreach($medals as $medal){

                if($medal->users->contains(auth()->user()->id)){
                    $medal['awarded'] = 'yes';
                }else{

                };
            }

            return view('backend.user.medals', compact('medals'));

        }
    }
    
    public function getReferral(){

        $count = 1;
        $referralss = User::with('plans')->whereMyUpline(auth()->user()->id)->whereUserTypes(1)->where('id', '<>', auth()->user()->id)->get();
        
        return view('backend.user.referrals', compact('referralss', 'count'));

    }
    
}
