<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

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
        'bio',
        'weight',
        'height',
        'date_of_birth',
        'gender',
        'profile_photo_path',
        'status',
        'banned_at'
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
            'date_of_birth' => 'date',
            'weight' => 'float',
            'height' => 'float'
        ];
    }

    // Methods for roles and permissions

    public function roles(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_role');
    }

    public function assignRole($roles): static
    {
        $this->roles()->syncWithoutDetaching($this->getRoleIds($roles));

        return $this;
    }

    protected function getRoleIds($roles): array
    {
        if (is_array($roles)) {
            return array_map(function ($role) {
                if ($role instanceof Role) {
                    return $role->id;
                } elseif (is_numeric($role)) {
                    return $role;
                } else {
                    // If it's a string, look up the role ID by name
                    $foundRole = Role::where('name', $role)->first();
                    if (!$foundRole) {
                        throw new \InvalidArgumentException("Role '$role' does not exist.");
                    }
                    return $foundRole->id;
                }
            }, $roles);
        }

        if ($roles instanceof Role) {
            return [$roles->id];
        } elseif (is_numeric($roles)) {
            return [$roles];
        } else {
            // If it's a string, look up the role ID by name
            $foundRole = Role::where('name', $roles)->first();
            if (!$foundRole) {
                throw new \InvalidArgumentException("Role '$roles' does not exist.");
            }
            return [$foundRole->id];
        }
    }

    public function hasRole($role): bool
    {
        if (is_string($role)) {
            return $this->roles()->where('name', $role)->exists();
        }

        if (is_int($role)) {
            return $this->roles()->where('id', $role)->exists();
        }

        if ($role instanceof Role) {
            return $this->roles()->where('id', $role->id)->exists();  // Fixed: missing parentheses
        }

        return false;  // Added default return value
    }

    public function hasAnyRole(array $roles): bool  // Fixed method name from hasAnyRoles to hasAnyRole
    {
        foreach ($roles as $role) {
            if ($this->hasRole($role)) {
                return true;
            }
        }
        return false;
    }

    // Add removeRole method for completeness
    public function removeRole($roles): static
    {
        $this->roles()->detach($this->getRoleIds($roles));

        return $this;
    }

    // Add hasAllRoles method
    public function hasAllRoles(array $roles): bool
    {
        foreach ($roles as $role) {
            if (!$this->hasRole($role)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Get the URL for the user's profile photo.
     */
    public function getProfilePhotoUrlAttribute(): string
    {
        if ($this->profile_photo_path) {
            return Storage::disk('public')->url($this->profile_photo_path);
        }

        return 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&color=7F9CF5&background=EBF4FF';
    }

    /**
     * Calculate BMI (Body Mass Index) if height and weight are provided.
     */
    public function getBmiAttribute(): float|null
    {
        if ($this->height && $this->weight) {
            $heightInMeters = $this->height / 100; // Convert cm to m
            return round($this->weight / ($heightInMeters * $heightInMeters), 1);
        }

        return null;
    }

    /**
     * Get BMI category.
     */
    public function getBmiCategoryAttribute(): string|null
    {
        $bmi = $this->bmi;

        if (!$bmi) return null;

        if ($bmi < 18.5) return 'Underweight';
        if ($bmi < 25) return 'Normal weight';
        if ($bmi < 30) return 'Overweight';
        return 'Obese';
    }

    /**
     * Get user's age based on date of birth.
     */
    public function getAgeAttribute(): int|null
    {
        if ($this->date_of_birth) {
            return $this->date_of_birth->age;
        }

        return null;
    }
}
