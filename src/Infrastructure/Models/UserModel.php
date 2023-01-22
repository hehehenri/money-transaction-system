<?php

namespace Src\Infrastructure\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    use HasUuids;

    protected $table = 'users';

    protected $fillable = [
        'id',
        'full_name',
        'email',
        'email_verified_at',
        'document',
        'password',
    ];

    protected $hidden = [
        'document',
        'password',
    ];
}
