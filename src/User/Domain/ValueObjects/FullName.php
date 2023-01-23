<?php

namespace Src\User\Domain\ValueObjects;

use Src\Shared\ValueObjects\StringValueObject;
use Src\User\Domain\Exceptions\UserValidationException;

class FullName extends StringValueObject
{
    private const MIN_LEN = 3;

    private const MAX_LEN = 150;

    /** @throws UserValidationException */
    public function __construct(string $value)
    {
        $this->validateLength($value);
        $this->validateCharacters($value);

        parent::__construct($value);
    }

    /** @throws UserValidationException */
    private function validateLength(string $value): void
    {
        if (strlen($value) < self::MIN_LEN || strlen($value) > self::MAX_LEN) {
            throw UserValidationException::fullNameLengthIsOutOfRange($value);
        }
    }

    /** @throws UserValidationException */
    private function validateCharacters(string $value): void
    {
        if (! preg_match("/^[a-zA-ZÀ-ÖØ-öø-ÿ' -]+$/", $value)) {
            throw UserValidationException::fullNameContainsInvalidCharacters($value);
        }
    }
}
