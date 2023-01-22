<?php

namespace Src\Customer\Presentation\Rest\Rules;


use Illuminate\Contracts\Validation\Rule;
use Src\Customer\Domain\UseCases\ValidateCPF;

final class CPFValidation implements Rule
{

    public static function validate(): self
    {
        return new self;
    }

    public function passes($attribute, $value): bool
    {
        $cpfIsValid = new ValidateCPF();

        return $cpfIsValid($value);
    }

    public function message(): string
    {
        return 'The :attribute must follow a valid CPF format.';
    }
}
