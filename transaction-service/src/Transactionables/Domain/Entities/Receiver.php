<?php

declare(strict_types=1);

namespace Src\Transactionables\Domain\Entities;

use Src\Transactionables\Domain\Enums\Provider;
use Src\Transactionables\Domain\ValueObjects\ReceiverId;

final class Receiver extends Transactionable
{
    public function __construct(ReceiverId $id, Provider $providerId)
    {
        parent::__construct($id, $providerId);
    }
}
