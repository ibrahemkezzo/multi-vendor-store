<?php

namespace App\Models;

use App\Concernes\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends User
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles;
    protected $table = 'admins';
    protected $fillable = [
        'name',
        'email',
        'username',
        'phone_number',
        'password',
        'super_admin',
        'status',
        'store_id',
    ];
    public function before($user, $ability)
    {
        if ($user->super_admin) {
            return true;
        }
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }

        // علاقة polymorphic many-to-many مع roles
    public function roles()
    {
        return $this->morphToMany(Role::class, 'authorizable', 'role_user');
    }

    // فحص هل الأدمن عنده دور معيّن
    public function hasRole($roleName)
    {
        return $this->roles()->where('name', $roleName)->exists();
    }
}
