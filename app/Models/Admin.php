<?php

namespace App\Models;

use App\Concernes\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends User
{
    use HasFactory , Notifiable ,HasApiTokens , HasRoles;
    protected $table = 'admins';
    protected $fillable = [
    'name',
    'email',
    'username',
    'phone_number',
    'password',
    'super_admin',
    'status',
];
public function before($user,$ability){
    if($user->super_admin){return true;}
}
}
