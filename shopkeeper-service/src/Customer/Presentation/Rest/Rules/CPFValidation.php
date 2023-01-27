<?php

namespace Src\Shopkeeper\Presentation\Rest\Rules;

use Illuminate\Contracts\Validation\Rule;
use Src\Shopkeeper\Domain\UseCases\CPFValidator;

final class CPFValidation implements Rule
{
    public static function validate(): self
    {
        return new self;
    }

    public function passes($attribute, $value): bool
    {
        if (! is_string($value)) {
            return false;
        }

        $validator = new CPFValidator();

        return $validator->validate($value);
    }

    public function message(): string
    {
        return 'The :attribute must follow a valid CPF format.';
    }
}
