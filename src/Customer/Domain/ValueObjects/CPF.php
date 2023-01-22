<?php

namespace Src\Customer\Domain\ValueObjects;

use Src\Customer\Domain\InvalidParameterException;
use Src\Customer\Domain\UseCases\CPFValidator;
use Src\User\Domain\ValueObjects\Document;

class CPF extends Document
{
    /** @throws InvalidParameterException */
    public function __construct(string $value)
    {
        $value = $this->removeNonNumericChars($value);

        $validator = new CPFValidator();

        if (! $validator->validate($value)) {
            throw InvalidParameterException::invalidCPF($value);
        }

        parent::__construct($value);
    }

    private function removeNonNumericChars(string $value): string
    {
        return preg_replace('/[^0-9]/', '', $value) ?? '';
    }
}
