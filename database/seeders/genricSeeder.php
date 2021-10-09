<?php

namespace Database\Seeders;

use auth;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use App\Models\publishing_plans;
use Illuminate\Support\Facades\Hash;

class genricSeeder extends Seeder
{
    public function run()
    {
        $password = Hash::make('12345654321');

        $settings = Setting::create([
            'referral_percent' => 5,
            'wallet_rate' => 415,
            'payment_delay' => 120,
            'official_mail' => 'davedeloper@gmail.com',
            'official_wallet' => 'asjhas%4jj@kaisaaaaaac',
            'naira_to_dollar' => 470,
        ]);


        $publishing_plan1 = publishing_plans::Create([
            'title' => 'Amateur',
            'amount' => 15000/$settings->naira_to_dollar,
            'validity' => 30,
            'commission' => 0.5,
            'daily_returns' => 800/$settings->naira_to_dollar,
            'return' => 24000/$settings->naira_to_dollar,
            'description' => '<ul class="list-unstyled p-0 pt-1"><li><i class="mdi mdi-check-circle"></i>$800 per promotion</li> 
            <li>        <i class="mdi mdi-check-circle"></i>0.5% promotion commission*</li> <li><i class="mdi mdi-check-circle"></i>$3 withdrawal fee</li></ul>',
        ]);

        $publishing_plan2 = publishing_plans::Create([
            'title' => 'Advance',
            'amount' => 25000/$settings->naira_to_dollar,
            'validity' => 30,
            'commission' => 0.5,
            'daily_returns' => 1333.33/$settings->naira_to_dollar,
            'return' => 40000/$settings->naira_to_dollar,
            'description' => '<ul class="list-unstyled p-0 pt-1"><li><i class="mdi mdi-check-circle"></i>$'.(133.33/$settings->naira_to_dollar) .'  per promotion</li> <li><i class="mdi mdi-check-circle"></i>0% promotion commission*</li> <li><i class="mdi mdi-check-circle"></i>$3 withdrawal fee</li></ul>',
        ]);

        $publishing_plan3 = publishing_plans::Create([
            'title' => 'Professional',
            'amount' => 50000/$settings->naira_to_dollar,
            'validity' => 30,
            'commission' => 0.5,
            'daily_returns' => 2666.67/$settings->naira_to_dollar,
            'return' => 80000/$settings->naira_to_dollar,
            'description' => '<ul class="list-unstyled p-0 pt-1"><li><i class="mdi mdi-check-circle"></i>$'.(2666.67/$settings->naira_to_dollar) .' per promotion</li> 
            <li><i class="mdi mdi-check-circle"></i>0% promotion commission*</li> <li><i class="mdi mdi-check-circle"></i>$3 withdrawal fee</li></ul>',
        ]);

        $publishing_plan4 = publishing_plans::Create([
            'title' => 'Chairman',
            'amount' => 150000/$settings->naira_to_dollar,
            'validity' => 30,
            'commission' => 0.5,
            'daily_returns' => 8000/$settings->naira_to_dollar,
            'return' => 240000/$settings->naira_to_dollar,
            'description' => '<ul class="list-unstyled p-0 pt-1"><li><i class="mdi mdi-check-circle"></i>$'.(8000/$settings->naira_to_dollar) .' per promotion</li> 
            <li><i class="mdi mdi-check-circle"></i>0% promotion commission*</li> <li><i class="mdi mdi-check-circle"></i>$3 withdrawal fee</li></ul>',
        ]);
        
        $publishing_plan5 = publishing_plans::Create([
            'title' => 'Governor',
            'amount' => 250000/$settings->naira_to_dollar,
            'validity' => 30,
            'commission' => 0.5,
            'daily_returns' => 13333.33/$settings->naira_to_dollar,
            'return' => 400000/$settings->naira_to_dollar,
            'description' => '<ul class="list-unstyled p-0 pt-1"><li><i class="mdi mdi-check-circle"></i>$'.(13333.33/$settings->naira_to_dollar) .' per promotion</li> 
            <li><i class="mdi mdi-check-circle"></i>0% promotion commission*</li> <li><i class="mdi mdi-check-circle"></i>$3 withdrawal fee</li></ul>',
        ]);

        $publishing_plan6 = publishing_plans::Create([
            'title' => 'President',
            'amount' => 500000/$settings->naira_to_dollar,
            'validity' => 30,
            'commission' => 0.5,
            'daily_returns' => 26666.67/$settings->naira_to_dollar,
            'return' => 800000/$settings->naira_to_dollar,
            'description' => '<ul class="list-unstyled p-0 pt-1"><li><i class="mdi mdi-check-circle"></i>$'.(26666.67/$settings->naira_to_dollar) .' per promotion</li> 
            <li><i class="mdi mdi-check-circle"></i>0% promotion commission*</li> <li><i class="mdi mdi-check-circle"></i>$3 withdrawal fee</li></ul>',
        ]);


        $admin1 = User::Create([
           'name' => 'David',
           'username' => 'adminone',
           'phone' => '08180010243',
           'my_referral_code' => 'adminone',
           'my_upline' => 1,
           'publishing_plans_id' => $publishing_plan1->id,
           'wallet_balance' => 200,
           'email' => 'admin1@gmail.com',
           'user_types' => 2,
           'email_verified_at' => '2021-02-17 09:50:49',
           'password' => $password,
        ]);

        $user1 = User::Create([
           'name' => 'User',
           'username' => 'userone',
           'phone' => '08180010243',
           'my_referral_code' => 'userone',
           'my_upline' => 1,
           'publishing_plans_id' => $publishing_plan1->id,
           'wallet_balance' => 900,
           'email' => 'user1@gmail.com',
           'email_verified_at' => '2021-02-17 09:50:49',
           'user_types' => 1,
           'password' => $password,
        ]);

        
    }
}
