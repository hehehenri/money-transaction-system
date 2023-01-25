<?php

namespace Src\Infrastructure\Models;

use Database\Factories\LedgerFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Src\Ledger\Domain\Entities\Ledger;
use Src\Shared\ValueObjects\Money;

/**
 * @extends Model<Ledger>
 *
 * @property TransactionableModel $transactionable
 * @property string $transactionable_id
 * @property int $balance
 */
class LedgerModel extends Model
{
    use HasUuids, HasFactory;

    protected $table = 'ledgers';
    protected $fillable = [
        'id',
        'transactionable_id',
        'balance',
    ];

    public function transactionable(): BelongsTo
    {
        return $this->belongsTo(TransactionableModel::class, 'transactionable_id', 'id');
    }

    public function intoEntity(): Ledger
    {
        $transactionable = $this->transactionable->intoEntity();

        return new Ledger(
            $transactionable,
            new Money($this->balance)
        );
    }

    protected static function newFactory(): LedgerFactory
    {
        return new LedgerFactory();
    }
}
