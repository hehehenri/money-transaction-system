<?php

namespace Tests\Feature\Transactions;

use Src\Infrastructure\Models\TransactionModel;
use Src\Transactions\Application\TransactionAuthorizer;
use Src\Transactions\Domain\Enums\TransactionStatus;
use Tests\TestCase;
use Tests\Traits\MocksAuthorizer;

class TransactionAuthorizerTest extends TestCase
{
    use MocksAuthorizer;

    public function testApprovesPendingTransaciton()
    {
        $this->authorize();

        /** @var TransactionModel $transaction */
        $transaction = TransactionModel::factory(['status' => TransactionStatus::PENDING])
            ->create();

        app(TransactionAuthorizer::class)->handle($transaction->intoEntity());

        $this->assertEquals(TransactionStatus::SUCCESS, $transaction->refresh()->status);
    }

    public function testRefusesPendingTransaction()
    {
        $this->refuse();

        /** @var TransactionModel $transaction */
        $transaction = TransactionModel::factory(['status' => TransactionStatus::PENDING])
            ->create();

        app(TransactionAuthorizer::class)
            ->handle($transaction->intoEntity());

        $this->assertEquals(TransactionStatus::REFUSED, $transaction->refresh()->status);
    }
}
