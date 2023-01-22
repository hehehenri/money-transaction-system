<?php

namespace Src\User\Domain\ValueObjects;

use Src\Shared\ValueObjects\StringValueObject;
use Src\User\Domain\Exceptions\InvalidParameterException;

class FullName extends StringValueObject
{
    private const MIN_LEN = 3;
    private const MAX_LEN = 150;

    /** @throws InvalidParameterException */
    public function __construct(string $value)
    {
        $this->validateLength($value);
        $this->validateCharacters($value);

        parent::__construct($value);
    }

    /** @throws InvalidParameterException */
    private function validateLength(string $value): void
    {
        if (strlen($value) < self::MIN_LEN || strlen($value) > self::MAX_LEN) {
            InvalidParameterException::fullNameLengthIsOutOfRange($value);
        }
    }

    /** @throws InvalidParameterException */
    private function validateCharacters(string $value)
    {
        if (!preg_match("/^[a-zA-ZÀ-ÖØ-öø-ÿ' -]+$/", $value)) {
            throw InvalidParameterException::fullNameContainsInvalidCharacters($value);
        }
    }
}
