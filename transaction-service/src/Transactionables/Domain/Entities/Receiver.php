<?php

declare(strict_types=1);

namespace Src\Transactionables\Domain\Entities;

use Src\Providers\Domain\ValueObjects\ProviderId;
use Src\Transactionables\Domain\ValueObjects\ReceiverId;

final class Receiver extends Transactionable
{
    public function __construct(ReceiverId $id, ProviderId $providerId)
    {
        parent::__construct($id, $providerId);
    }
}
