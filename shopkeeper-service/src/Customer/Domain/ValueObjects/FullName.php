<?php

namespace Src\Shopkeeper\Domain\ValueObjects;

use Src\Auth\Domain\Exceptions\ShopkeeperValidationException;
use Src\Shared\ValueObjects\StringValueObject;

class FullName extends StringValueObject
{
    private const MIN_LEN = 3;

    private const MAX_LEN = 150;

    /** @throws ShopkeeperValidationException */
    public function __construct(string $value)
    {
        $this->validateLength($value);
        $this->validateCharacters($value);

        parent::__construct($value);
    }

    /** @throws ShopkeeperValidationException */
    private function validateLength(string $value): void
    {
        if (strlen($value) < self::MIN_LEN || strlen($value) > self::MAX_LEN) {
            throw ShopkeeperValidationException::fullNameLengthIsOutOfRange($value);
        }
    }

    /** @throws ShopkeeperValidationException */
    private function validateCharacters(string $value): void
    {
        if (! preg_match("/^[a-zA-ZÀ-ÖØ-öø-ÿ' -]+$/", $value)) {
            throw ShopkeeperValidationException::fullNameContainsInvalidCharacters($value);
        }
    }
}
