<?php

namespace Tests\Unit\Transactions\UseCases;

use Src\Infrastructure\Models\TransactionModel;
use Src\Transactions\Domain\UseCases\ApprovationTimedOut;
use Tests\TestCase;

class ApprovationTimedOutTest extends TestCase
{
    /**
     * @dataProvider cases
     */
    public function testTransactionExpiresAfterSpecifiedTime(int $ttl, bool $expired): void
    {
        /** @var TransactionModel $transaction */
        $transaction = TransactionModel::factory(['created_at' => now()->subSeconds($ttl + 1)])->create();

        $timmedOut = (new ApprovationTimedOut())->check($transaction->intoEntity());

        $this->assertEquals($expired, $timmedOut);
    }

    /** @return array<array<int, bool>> */
    public function cases(): array
    {
        return [
            [5 * 60, true],
            [4 * 60, false]
        ];
    }
}
