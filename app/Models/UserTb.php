<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserTb extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $table = 'user_tb';
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'user_username',
        'user_password',
        'user_name',
    ];

    protected $hidden = [
        'user_password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'user_password' => 'hashed',
        ];
    }

    public function getAuthIdentifierName(): string
    {
        return $this->primaryKey; // 'id_user'
    }

    public function getAuthIdentifier(): mixed
    {
        return $this->{$this->primaryKey};
    }
    public function getAuthPasswordName(): string
    {
        return 'user_password';
    }

    public function getAuthPassword(): string
    {
        return $this->user_password;
    }

    public function penilaians()
    {
        return $this->hasMany(PenilaianTb::class, 'id_user', 'id_user');
    }
}
