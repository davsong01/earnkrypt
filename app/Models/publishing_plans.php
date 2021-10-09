<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class publishing_plans extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public function users(){
        return $this->hasMany(User::class);
    }
}
