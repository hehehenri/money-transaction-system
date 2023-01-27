<?php

namespace Src\Shopkeeper\Presentation\Rest\Rules;

use Illuminate\Contracts\Validation\Rule;
use Src\Auth\Domain\Exceptions\ShopkeeperValidationException;
use Src\Shopkeeper\Domain\ValueObjects\FullName;

final class FullNameValidation implements Rule
{
    public static function validate(): self
    {
        return new self();
    }

    public function passes($attribute, $value): bool
    {
        if (! is_string($value)) {
            return false;
        }

        try {
            new FullName($value);

            return true;
        } catch (ShopkeeperValidationException) {
            return false;
        }
    }

    public function message(): string
    {
        return 'The :attribute can only contain letters, spaces, hyphens, and apostrophes.';
    }
}