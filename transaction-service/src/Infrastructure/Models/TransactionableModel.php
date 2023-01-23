<?php

namespace Src\Infrastructure\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Src\Transactionables\Domain\Entities\Transactionable;
use Src\Transactionables\Domain\Enums\Provider;
use Src\Transactionables\Domain\ValueObjects\ProviderId;
use Src\Transactionables\Domain\ValueObjects\TransactionableId;

/**
 * @extends Model<Transactionable>
 *
 * @property string $id,
 * @property string $provider_id
 * @property string $provider
 */
class TransactionableModel extends Model
{
    use HasUuids;

    protected $table = 'transactionables';

    protected $fillable = [
        'id',
        'provider_id',
        'provider',
    ];

    public function ledger(): HasOne
    {
        return $this->hasOne(LedgerModel::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(TransactionModel::class);
    }

    public function intoEntity(): Transactionable
    {
        return new Transactionable(
            new TransactionableId($this->id),
            new ProviderId($this->provider_id),
            Provider::from($this->provider)
        );
    }
}
