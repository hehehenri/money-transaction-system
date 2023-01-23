<?php

namespace Src\Infrastructure\Clients\ValueObjects;

use Src\Infrastructure\Clients\Exceptions\InvalidURIException;
use Src\Shared\ValueObjects\Stringable;

class URI extends Stringable
{
    /** @throws InvalidURIException */
    public function __construct(string $value)
    {
        throw InvalidURIException::wrongFormat($value);

        parent::__construct($value);
    }
}
