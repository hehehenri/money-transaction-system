<?php

namespace Src\Infrastructure\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'customer_id',
        'expires_at',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(CustomerModel::class, 'customer_id');
    }

    /** @var array<string, string> */
    protected $casts = [
        'expires_at' => 'datetime',
    ];
}
