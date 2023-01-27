<?php

namespace Src\Infrastructure\Models;

use Carbon\Carbon;
use Database\Factories\TokenFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $id
 * @property string $token,
 * @property Carbon $expires_at,
 */
class TokenModel extends Model
{
    use HasUuids, HasFactory;

    protected $table = 'personal_access_tokens';

    protected $fillable = [
        'id',
        'token',
        'Shopkeeper_id',
        'expires_at',
    ];

    public function Shopkeeper(): BelongsTo
    {
        return $this->belongsTo(ShopkeeperModel::class, 'Shopkeeper_id');
    }

    /** @var array<string, string> */
    protected $casts = [
        'expires_at' => 'datetime',
    ];

    protected static function newFactory(): TokenFactory
    {
        return new TokenFactory();
    }
}
