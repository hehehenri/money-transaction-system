<?php

namespace Src\Customer\Domain\ValueObjects;

use Src\Customer\Domain\InvalidParameterException;
use Src\Customer\Domain\UseCases\CPFValidator;
use Src\User\Domain\ValueObjects\Document;

class CPF extends Document
{
    public function __construct(string $value)
    {
        $validator = new CPFValidator();

        if (! $validator->validate($value)) {
            InvalidParameterException::invalidCPF($value);
        }

        parent::__construct($value);
    }
}
