<?php

namespace Src\User\Domain\ValueObjects;

use Src\Shared\Exceptions\InvalidParameterException;
use Src\Shared\ValueObjects\StringValueObject;
use Src\User\Domain\Exceptions\InvalidParametersException;

class FullName extends StringValueObject
{
    private const MIN_LEN = 3;
    private const MAX_LEN = 150;

    /** @throws InvalidParametersException */
    public function __construct(string $value)
    {
        $this->validateLength($value);
        $this->validateCharacters($value);

        parent::__construct($value);
    }

    /** @throws InvalidParametersException */
    private function validateLength(string $value): void
    {
        if (strlen($value) < self::MIN_LEN || strlen($value) > self::MAX_LEN) {
            InvalidParametersException::fullNameLengthIsOutOfRange($value);
        }
    }

    /** @throws InvalidParametersException */
    private function validateCharacters(string $value)
    {
        if (!preg_match('/^[a-zA-Z\s\-\']+$/', $value)) {
            throw InvalidParametersException::fullNameContainsInvalidCharacters($value);
        }
    }
}
