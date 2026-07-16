<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $table = 'admin';
    protected $primaryKey = 'id_admin';

    protected $fillable = [
        'admin_username',
        'admin_password',
        'admin_name',
    ];

    protected $hidden = [
        'admin_password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'admin_password' => 'hashed',
        ];
    }

    /**
     * The column used as the unique identifier for session serialization.
     * We use the PK column name so Laravel stores id_admin in the session.
     */
    public function getAuthIdentifierName(): string
    {
        return $this->primaryKey; // 'id_admin'
    }

    /**
     * The value stored in the session (the PK value).
     */
    public function getAuthIdentifier(): mixed
    {
        return $this->{$this->primaryKey};
    }

    /**
     * The column name used to store the hashed password.
     */
    public function getAuthPasswordName(): string
    {
        return 'admin_password';
    }

    /**
     * Return the actual hashed password value for auth.
     */
    public function getAuthPassword(): string
    {
        return $this->admin_password;
    }
}
