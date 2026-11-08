<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Admin account. The hash lives in the `password_hash` column (as in the
 * handover schema), so we tell Laravel's auth system where to find it.
 */
class Admin extends Authenticatable
{
    protected $fillable = ['username', 'password_hash'];

    protected $hidden = ['password_hash'];

    public function getAuthPassword(): string
    {
        return $this->password_hash;
    }

    public function getAuthPasswordName(): string
    {
        return 'password_hash';
    }

    // No "remember me" for admins -> no remember_token column needed.
    public function getRememberTokenName(): string
    {
        return '';
    }
}
