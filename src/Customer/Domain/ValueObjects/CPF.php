<?php

namespace Src\Customer\Domain\ValueObjects;

use Src\Customer\Domain\InvalidParameterException;
use Src\Customer\Domain\UseCases\ValidateCPF;
use Src\User\Domain\ValueObjects\Document;

class CPF extends Document
{
    public function __construct(string $value)
    {
        $isValid = new ValidateCPF();

        if (!$isValid($value)) {
            InvalidParameterException::invalidCPF($value);
        };

        parent::__construct($value);
    }
}
