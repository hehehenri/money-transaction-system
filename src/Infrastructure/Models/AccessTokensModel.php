<?php

namespace Src\Infrastructure\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property string $id
 * @property string $name,
 * @property string $token,
 * @property ?Carbon $last_used_at,
 * @property ?Carbon $expires_at,
 */
class AccessTokensModel extends Model
{
    use HasUuids;

    protected $table = 'personal_access_tokens';

    protected $fillable = [
        'id',
        'tokenable',
        'name',
        'token',
        'last_used_at',
        'expires_at',
    ];

    public function tokenable(): MorphTo
    {
        return $this->morphTo();
    }
}
