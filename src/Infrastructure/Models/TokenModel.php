<?php

namespace Src\Infrastructure\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property string $token,
 * @property Carbon $expires_at,
 */
class TokenModel extends Model
{
    use HasUuids;

    protected $table = 'personal_access_tokens';

    protected $fillable = [
        'id',
        'token',
        'tokenable_type',
        'tokenable_id',
        'expires_at',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'expires_at' => 'datetime',
    ];
}
