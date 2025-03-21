<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    // Methods for roles and permissions

    public function roles(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function hasRole($role) : bool
    {
        if(is_string($role)) {
            return $this->roles()->where('name', $role)->exists();
        }

        if(is_int($role)) {
            return $this->roles()->where('id', $role)->exists();
        }

        if($role instanceof Role) {
            return $this->roles()->where('id', $role->id)->exists;
        }
    }

    public function hasAnyRoles(array $roles) : bool
    {
        foreach($roles as $role) {
            if($this->hasRole($role)) {
                return true;
            }
        }
        return false;
    }
}
