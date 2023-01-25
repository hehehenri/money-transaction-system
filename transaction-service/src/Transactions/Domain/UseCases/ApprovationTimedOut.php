<?php

namespace Src\Transactions\Domain\UseCases;

use DateInterval;
use DateTime;
use Src\Transactions\Domain\Entities\Transaction;

class ApprovationTimedOut
{
    public function check(Transaction $transaction): bool
    {
        /** @var int $ttl */
        $ttl = config('transactions.aprovation_timeout');
        /** @var DateInterval $interval */
        $interval = DateInterval::createFromDateString(sprintf('%s seconds', $ttl));

        $expiresAt = $transaction->createdAt->add($interval);
        $now = new DateTime();

        return $expiresAt < $now;
    }
}
