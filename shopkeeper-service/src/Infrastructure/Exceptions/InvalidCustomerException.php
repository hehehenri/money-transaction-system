<?php

namespace Src\Infrastructure\Exceptions;

use Src\Shopkeeper\Domain\Exceptions\ShopkeeperRepositoryException;
use Src\Shopkeeper\Domain\ValueObjects\ShopkeeperId;
use Src\Shopkeeper\Domain\ValueObjects\Email;

class InvalidShopkeeperException extends ShopkeeperRepositoryException
{
    public static function failedToBuildShopkeeperFromDatabase(string $id): self
    {
        return new self(sprintf(
            'Failed to build from a existing database Shopkeeper with ID<%s>.',
            $id
        ));
    }

    public static function idNotFound(ShopkeeperId $id): self
    {
        return new self(sprintf('Shopkeeper with ID<%s> was not found.', $id));
    }

    public static function emailNotFound(Email $email): self
    {
        return new self(sprintf('Shopkeeper with email<%s> was not found.', $email));
    }
}
