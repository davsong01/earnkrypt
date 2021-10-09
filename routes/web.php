<?php

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Jobs\UpdateUserWallet;
use App\Models\publishing_plans;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\pagesController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\AdvertController;
use App\Http\Controllers\DesignController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\WithdrawalController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/queue', function () {
    // Artisan::call('queue:flush');
    // Artisan::call('queue:work --tries=2');
    Artisan::call('queue:work');
});

Auth::routes();



Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('/changepassword/{email}', function($email){
    $user = User::where('email','=',$email)->first();
    $user->password = Hash::make($user->email); 
    $user->save();
    return 'user password is now same as email';
});

Route::get('viewvendor', function(){
    $vendors = Vendor::all();
    return view('backend.user.vendors', compact('vendors'));
})->name('vendor.viewall')->middleware('auth');

Route::get('/seecharges', function (){

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
        'X-CC-Api-Key: 6532eaad-cc55-4870-853f-fe0940395b61',
        'Cookie: amplitude_device_id=f1103d1d-59eb-4137-b39a-336c6ca6005f; coinbase_device_id=f1103d1d-59eb-4137-b39a-336c6ca6005f; __cfduid=d2500406439c2f8fc3bde13952b2dc16c1620210312'
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $jsonresponse = json_decode($response);

    foreach ($jsonresponse->data as $data) {
        # check for payment status
        if (isset($data->payments)) {
            # echo 'payment made<br>';
            # check if the payment is confirmed 
        }else{
            echo 'no made payment<br>';
        }
    }

});

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


Auth::routes(['verify' => true]);

Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('config:clear');
    echo "<p>Fully optimized.*</p>";
});

//Social login routes
Route::get('facebook', function () {
    return view('facebook');
});

Route::get('oauth/{driver}', [LoginController::class, 'redirectToProvider'])->name('social.oauth');
Route::get('oauth/{driver}/callback', [LoginController::class, 'handleProviderCallback'])->name('social.callback');

Route::get('/', [pagesController::class, 'index'])->name('index');

// //Route to select plan//Route to renew plan
// Route::get('', function(){
//     $plans = publishing_plans::all();
//     return view('backend.user.selectplans', compact('plans'));
// })->name('')->middleware(['auth', 'verified']);
Route::get('/selectplans', [pagesController::class, 'selectplans'])->name('select.plan')->middleware(['auth', 'verified']);
// Route::get('/selectplans', function(){
//     $plans = publishing_plans::all();
//     if(auth()->user()->plans()->count() > 0){
//         return redirect(route('renew.plan'));
//     }
//     return view('backend.user.selectplans', compact('plans'));
// })->name('renew.plan')->middleware(['auth', 'verified']);

Route::get('/userselectnewplan', function(){
    $plans = publishing_plans::where('id', '!=', auth()->user()->publishing_plans_id)->get();
    return view('backend.user.selectnewplan', compact('plans'));
})->middleware(['auth', 'verified']);

//Route to renew plan
Route::get('/renewplan', function(){
    $plan = auth()->user()->plans;
    return view('backend.user.renewplans', compact('plan'));
})->name('renew.plan')->middleware(['auth', 'verified']);


Route::get('/test', [pagesController::class, 'test'])->name('payment.test');

Route::post('/payment', [pagesController::class, 'payment2'])->name('payment2');
Route::get('/payment', [pagesController::class, 'payment'])->name('payment');
// Route::get('/paymentpost', [pagesController::class, 'payment'])->name('payment');

//Auth Subscriber routes
Route::middleware(['verified', 'auth', 'hasPlan', 'expiredPlan'])->group(function(){
    Route::get('/dashboard', [pagesController::class, 'dashboard'])->name('dashboard');
    Route::get('/promote', [pagesController::class, 'promote'])->name('promote.index');
    Route::post('/promote/save', [pagesController::class, 'savePromotion'])->name('promote.save');
    Route::get('/promote/save/{media}', [pagesController::class, 'newPromotion'])->name('promote.new');
    Route::resource('tasks', '\App\Http\Controllers\TasksController');
    Route::resource('withdraw', '\App\Http\Controllers\WithdrawalController');
    Route::get('withdraw/delete/{id}', [WithdrawalController::class, 'deleteWithdrawal'])->name('withdrawal.delete');
   
    Route::get('/referral', [UserController::class, 'getReferral'])->name('referrals');
    
    
});

//Account Routes
Route::middleware(['verified', 'auth', 'hasPlan'])->group(function(){
    Route::get('profile/{id}/edit', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::patch('profile/{id}/update', [UserController::class, 'saveProfile'])->name('profile.update');
    Route::get('profile/security', [UserController::class, 'editSecurityProfile'])->name('profile.security');
    Route::patch('profile/security', [UserController::class, 'saveSecurityProfile'])->name('security.save');
    Route::get('profile/billing', [UserController::class, 'editBillingProfile'])->name('profile.billing');
    Route::get('/user/medals', [UserController::class, 'getMedals'])->name('medals.get');
    
  
     //Get Media
    Route::get('uploads/{path}/{media}', function($path, $media){
        $realpath = base_path() . '/uploads'. '/' .$path. '/'. $media;
            return response()->download($realpath);  
    });
});

//Admin only routes
Route::resource('medal', '\App\Http\Controllers\MedalController')->middleware('auth');

Route::middleware(['admin', 'auth'])->group(function(){
    Route::resource('plans', '\App\Http\Controllers\PublishingPlansController');
    Route::resource('vendor', '\App\Http\Controllers\VendorController');
    Route::resource('user', '\App\Http\Controllers\UserController');
    Route::resource('setting', '\App\Http\Controllers\SettingController');
    Route::resource('admins', '\App\Http\Controllers\AdminController');
    Route::resource('transaction', '\App\Http\Controllers\TransactionController');
});

Route::resource('advert', '\App\Http\Controllers\AdvertController');
Route::POST('approvedesign/{id}', [DesignController::class, 'approveDesign'])->name('design.approve');
Route::POST('advertpay', [AdvertController::class, 'processPayment'])->name('advert.pay');

Route::resource('design', '\App\Http\Controllers\DesignController');
Route::get('approveadvert/{id}', [AdvertController::class, 'approveAdvert'])->name('advert.approve');
Route::POST('designpay', [DesignController::class, 'processPayment'])->name('design.pay');

