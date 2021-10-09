<?php

namespace App\Models;

use App\Models\Task;
use App\Models\User;
use App\Models\Medal;
use App\Models\Withdrawal;
use App\Models\Transaction;
use App\Models\publishing_plans;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail

{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'plan_expiry' => 'datetime',
    ];

    public function plans(){
        return $this->belongsTo(publishing_plans::class, 'publishing_plans_id');
    }

    public function transactions(){
        return $this->hasMany(Transaction::class);
    }

    public function upline(){
        return $this->belongsTo(User::class, 'my_upline');
    }

    public function tasks(){

        return $this->belongsToMany(Task::class);

    } 

    public function medals(){
        return $this->belongsToMany(Medal::class);
    } 

    public function withdraw(){
        $timestamp = time()-86400;
        $date = strtotime("-30 day", $timestamp);
        $today = date('Y-m-d H:i:s');
        $a_month_ago = date('Y-m-d 00:00:00', $date);

        return $this->hasMany(Withdrawal::class)->where('wallet_type', 'wallet')->where('created_at', '>=', $a_month_ago )->where('created_at', '<=', $today )->count();
    }

    public function completedTasks(){
        $beginning_of_today = date('Y-m-d 00:00:00');
        $end_of_today = date('Y-m-d 23:59:59');

        return $this->belongsToMany(Task::class)->where('task_user.created_at', '>=', $beginning_of_today )->where('task_user.created_at', '<=', $end_of_today )->count();
    }

}
