<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable  = [
        'name',
        'description',
    ];

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_role');
    }

    public function permissions(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }

    public function hasPermission($permission) : bool
    {
        if(is_string($permission)) {
            return $this->permissions()->where('name', $permission)->exists();
        }

        if(is_int($permission)) {
            return $this->permissions()->where('id', $permission)->exists();
        }

        if($permission instanceof Permission) {
            return $this->permissions()->where('id', $permission->id)->exists();
        }
    }

    public function hasAnyPermission(array $permissions) : bool
    {
        foreach($permissions as $permission) {
            if($this->hasPermission($permission)) {
                return true;
            }
        }
        return false;
    }

    public function givePermissionTo($permissions): static
    {
//        dd($this->getPermissionsIds($permissions));
        $this->permissions()->syncWithoutDetaching($this->getPermissionsIds($permissions));
        return $this;
    }

    public function revokePermissions($permissions): static
    {
        $this->permissions()->detach($this->getPermissionsIds($permissions));
        return $this;
    }

    public function getPermissionsIds($permissions)
    {
        if(is_array($permissions)) {
            return array_map(function ($permission) {
                return $permission instanceof Permission ? $permission->id : $permission;
            }, $permissions);
        }

        return [$permissions instanceof Permission ? $permissions->id : $permissions];
    }
}
