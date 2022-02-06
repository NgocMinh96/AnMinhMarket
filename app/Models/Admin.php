<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\MyTrait\HasPermissionsTrait;

class Admin extends Authenticatable
{
    use Notifiable;
    use HasPermissionsTrait; //Import App\MyTrait\HasPermissionsTrait

    protected $guard = 'admin';

    protected $fillable = [
        'id', 'name', 'username', 'password', 'status',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function checkPermission($permission)
    {
        $roles = auth()->user()->roles;
        foreach ($roles as $role) {
            $permissions = $role->permissions;
            if ($permissions->contains('slug', $permission)) {
                return true;
            }
        }
        return false;
    }
}
