<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $table = 'password_reset_tokens';
    protected $fillable = ['email', 'token'];

    public $primaryKey = 'email';
    public $incrementing = false;

    public $timestamps = false;
}
