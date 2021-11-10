<?php

namespace App\Http\Controllers\Auth;


use App\Models\User;
use App\Models\Medal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{

    use RegistersUsers;

     protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
      
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            // 'lastname' => ['required', 'string', 'max:255'],
            'username' => ['string', 'unique:users'],
            'phone' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
    
        //Assign admin referral to this user if he doesn't fill any
       if($data['my_upline'] == NULL ){
            $upline = User::whereUserTypes('3')->first();
       
            $my_upline = $upline->id;
      
       }

       if($data['my_upline'] != NULL ){
            $upline = User::whereUsername($data['my_upline'])->first();
            
            if(isset($upline)){
                $my_upline = $upline->id;

            }else{
                $upline = User::whereUserTypes('3')->first();
       
                $my_upline = $upline->id; 
            }
          
       }

        $user = User::create([
            'name' => $data['name'],
            'my_upline' => $my_upline,
            'phone' => $data['phone'],
            'email' => $data['email'],
            'username' => $data['username'],
            'my_referral_code' => $data['username'],
            'phone' =>  $data['phone'],
            'phone' =>  $data['phone'],
            'password' => Hash::make($data['password']),
        ]);

        return $user;
        
    }
    

    // private function awardMedal($upline){
        
    //     $referrals = User::whereMyUpline($upline->id)->whereUserTypes(1)->get();
    //     $count = $referrals->count();
        
    //     //Prepare for slow and steady medal
    //     $timestamp = time()-86400;
    //     $date = strtotime("-6 day", $timestamp);
    //     $today = date('Y-m-d H:i:s');
    //     $aweek_ago = date('Y-m-d 00:00:00', $date);

    //     $slow_and_steady_counter = $referrals->where('created_at', '<=', $today )->where('created_at', '>=', $aweek_ago );

    //     // SLOW AND STEADY
    //     // REFER 15 FRIENDS WITHIN 1 WEEK-$15
    //     if($slow_and_steady_counter->count() == 15){
    //          $upline->medals()->attach(2, [
    //             'created_at' =>  date("Y-m-d H:i:s"),
    //         ]);

    //         $upline->medals_wallet_balance = $upline->medals_wallet_balance + Medal::whereId(2)->value('value');

    //         $upline->save();
         
    //     }

    //     //Earn Ambasador Medal
    //     if($count == 5){
    //         $upline->medals()->attach(1, [
    //             'created_at' =>  date("Y-m-d H:i:s"),
    //         ]);

    //         $upline->medals_wallet_balance = $upline->medals_wallet_balance + Medal::whereId(1)->value('value');

    //         $upline->save();
    //     }

    //     //Earn I am a Titan Medal
    //     if($count == 30){
    //         $upline->medals()->attach(3, [
    //             'created_at' =>  date("Y-m-d H:i:s"),
    //         ]);

    //         $upline->medals_wallet_balance = $upline->medals_wallet_balance + Medal::whereId(3)->value('value');

    //         $upline->save();
    //     }

    //     //Earn PASS ME THE GOLD
    //     if($count == 60){
    //         $upline->medals()->attach(4, [
    //             'created_at' =>  date("Y-m-d H:i:s"),
    //         ]);

    //         $upline->medals_wallet_balance = $upline->medals_wallet_balance + Medal::whereId(4)->value('value');

    //         $upline->save();
    //     }

    //     //Earn I AM LEGENDARY 
    //     if($count == 120){
    //         $upline->medals()->attach(5, [
    //             'created_at' =>  date("Y-m-d H:i:s"),
    //         ]);

    //         $upline->medals_wallet_balance = $upline->medals_wallet_balance + Medal::whereId(5)->value('value');

    //         $upline->save();
    //     }  

    // }
}
