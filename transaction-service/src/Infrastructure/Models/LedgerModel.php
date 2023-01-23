<?php

namespace Src\Infrastructure\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Src\Ledger\Domain\Entities\Ledger;
use Src\Shared\ValueObjects\Money;

/**
 * @extends Model<Ledger>
 *
 * @property TransactionableModel $transactionable
 * @property int $amount
 */
class LedgerModel extends Model
{
    use HasUuids;

    protected $fillable = [
        'transactionable_id',
        'amount',
    ];

    public function transactionable(): BelongsTo
    {
        return $this->belongsTo(TransactionableModel::class);
    }

    public function intoEntity(): Ledger
    {
        $transactionable = $this->transactionable->intoEntity();

        return new Ledger(
            $transactionable,
            new Money($this->amount)
        );
    }
}
