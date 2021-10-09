<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


class LoginController extends Controller
{

    use AuthenticatesUsers;

    protected $redirectTo = '/dashboard';
  
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

     protected $providers = [
        'github','facebook','google','twitter'
    ];

    public function show()
    {
      
        return view('auth.login');
    }

    public function redirectToProvider($driver)
    {
    
        if( ! $this->isProviderAllowed($driver) ) {
            return $this->sendFailedResponse("{$driver} is not currently supported");
        }

        try {
            return Socialite::driver($driver)->redirect();
        } catch (Exception $e) {

            // You should show something simple fail message
            return $this->sendFailedResponse('Something went wrong');
        }
    }

  
    public function handleProviderCallback( $driver )
    {

        
        $userSocial =   Socialite::driver($driver)->stateless()->user();
        $user       =   User::where(['email' => $userSocial->getEmail()])->first();
        
        if($user){
           
            if(!$userSocial->getEmail()){
                return redirect(route('login'))->with('error', 'Cannot log in with'.$driver.', no email found!');
            }
                        
            $user->update([
                'avatar' => $userSocial->avatar,
                'provider' => $driver,
                'provider_id' => $userSocial->id,
                'access_token' => $userSocial->token
            ]);

        }else{    
            // Create a new user
           
            $user = User::where('username', preg_replace('/\s/', '', $userSocial->getName()))->first();
            if($user){
                $username =  $user->username. rand(1,100);
            }else{
                $username->$userSocial->getEmail();
            }

            $user = User::Create([
                'name' => $userSocial->getName(),
                'username' => $username,
                'email' => $userSocial->getEmail(),
                'avatar' => $userSocial->getAvatar(),
                'provider' => $driver,
                'provider_id' => $userSocial->getId(),
                'access_token' => $userSocial->token,
                'password' => '',
                'email_verified_at' => now(),
            ]);
  
        }

            //Login User
            Auth::login($user, true);
       
            //Return user to page to fill remaining details if password is not set
            return redirect(route('dashboard'));
      
    }

    protected function sendSuccessResponse()
    {
        return redirect()->intended('dashboard');
    }

    protected function sendFailedResponse($msg = null)
    {
        return redirect()->route('social.login')
            ->withErrors(['msg' => $msg ?: 'Unable to login, try with another provider to login.']);
    }


    private function isProviderAllowed($driver)
    {
        return in_array($driver, $this->providers) && config()->has("services.{$driver}");
    }
}
