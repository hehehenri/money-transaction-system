<?php

namespace Src\Infrastructure\Clients\Http\TransactionsService\Exceptions;

use Exception;
use Src\Customer\Domain\ValueObjects\CustomerId;

class ResourceNotFoundException extends Exception
{
    public static function balanceNotFound(CustomerId $id): self
    {
        return new self(sprintf('A balance for the customer with ID<%s> was not found', $id));
    }
}
