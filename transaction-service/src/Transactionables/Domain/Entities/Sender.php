<?php

declare(strict_types=1);

namespace Src\Transactionables\Domain\Entities;

use Src\Providers\Domain\ValueObjects\ProviderId;
use Src\Transactionables\Domain\ValueObjects\SenderId;

final class Sender extends Transactionable
{
    public function __construct(SenderId $id, ProviderId $providerId)
    {
        parent::__construct($id, $providerId);
    }
}
