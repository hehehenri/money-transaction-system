<?php

namespace Src\Customer\Domain\ValueObjects;

use Src\Auth\Domain\Exceptions\CustomerValidationException;
use Src\Shared\ValueObjects\StringValueObject;

class FullName extends StringValueObject
{
    private const MIN_LEN = 3;

    private const MAX_LEN = 150;

    /** @throws CustomerValidationException */
    public function __construct(string $value)
    {
        $this->validateLength($value);
        $this->validateCharacters($value);

        parent::__construct($value);
    }

    /** @throws CustomerValidationException */
    private function validateLength(string $value): void
    {
        if (strlen($value) < self::MIN_LEN || strlen($value) > self::MAX_LEN) {
            throw CustomerValidationException::fullNameLengthIsOutOfRange($value);
        }
    }

    /** @throws CustomerValidationException */
    private function validateCharacters(string $value): void
    {
        if (! preg_match("/^[a-zA-ZÀ-ÖØ-öø-ÿ' -]+$/", $value)) {
            throw CustomerValidationException::fullNameContainsInvalidCharacters($value);
        }
    }
}
