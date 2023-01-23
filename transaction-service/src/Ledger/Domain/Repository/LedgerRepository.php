<?php

namespace Src\Ledger\Domain\Repository;

use Src\Ledger\Domain\DTOs\LedgerOperationDTO;
use Src\Ledger\Domain\Entities\Ledger;

interface LedgerRepository
{
    public function sended(LedgerOperationDTO $dto): Ledger;

    public function received(LedgerOperationDTO $dto): Ledger;
}
