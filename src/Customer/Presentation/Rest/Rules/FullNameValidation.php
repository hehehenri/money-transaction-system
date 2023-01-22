<?php

namespace Src\Customer\Presentation\Rest\Rules;

use Illuminate\Contracts\Validation\Rule;
use Src\User\Domain\Exceptions\InvalidParameterException;
use Src\User\Domain\ValueObjects\FullName;

final class FullNameValidation implements Rule
{
    public static function validate(): self
    {
        return new self();
    }
    public function passes($attribute, $value): bool
    {
        try {
            new FullName($value);

            return true;
        } catch (InvalidParameterException) {
            return false;
        }
    }

    public function message(): string
    {
        return 'The :attribute can only contain letters, spaces, hyphens, and apostrophes.';
    }
}
