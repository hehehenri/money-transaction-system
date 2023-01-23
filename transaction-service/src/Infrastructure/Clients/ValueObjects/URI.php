<?php

namespace Src\Infrastructure\Clients\ValueObjects;

use Src\Infrastructure\Clients\Exceptions\InvalidURIException;
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
