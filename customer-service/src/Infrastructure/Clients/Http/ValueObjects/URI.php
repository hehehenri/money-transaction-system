<?php

namespace Src\Infrastructure\Clients\Http\ValueObjects;

use Src\Infrastructure\Clients\Http\Exceptions\InvalidURIException;
use Src\Shared\ValueObjects\Stringable;

class URI extends Stringable
{
    /** @throws InvalidURIException */
    public function __construct(string $value)
    {
        if (! filter_var($value, FILTER_VALIDATE_URL)) {
            throw InvalidURIException::wrongFormat($value);
        }

        parent::__construct($value);
    }
}
