<?php

namespace Src\Infrastructure\Clients\Http\ValueObjects;

use Src\Infrastructure\Clients\Http\Exceptions\InvalidURLException;
use Src\Shared\ValueObjects\StringValueObject;

class BaseUrl extends StringValueObject
{
    /** @throws InvalidURLException */
    public function __construct(string $value)
    {
        if (! filter_var($value, FILTER_VALIDATE_URL)) {
            throw InvalidURLException::wrongFormat($value);
        }

        parent::__construct($value);
    }
}
