<?php

namespace Src\Shopkeeper\Domain\ValueObjects;

use Src\Shopkeeper\Domain\InvalidParameterException;
use Src\Shopkeeper\Domain\UseCases\CPFValidator;

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
