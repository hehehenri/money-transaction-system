<?php

namespace Src\Infrastructure\Clients\Http\TransactionsService\Exceptions;

use Exception;
use Src\Shopkeeper\Domain\ValueObjects\ShopkeeperId;

class ResourceNotFoundException extends Exception
{
    public static function balanceNotFound(ShopkeeperId $id): self
    {
        return new self(sprintf('A balance for the Shopkeeper with ID<%s> was not found', $id));
    }

    public static function transactionableNotFound(): self
    {
        return new self('One of the given transactionables was not found.');
    }
}
