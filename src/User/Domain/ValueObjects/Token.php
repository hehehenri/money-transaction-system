<?php

namespace Src\User\Domain\ValueObjects;

use Src\Shared\ValueObjects\StringValueObject;

abstract class Token extends StringValueObject
{
    /** @param  array<string, string>  $payload */
    abstract public static function encode(array $payload): self;

    /** @return array<string, string> */
    abstract public function decode(): array;
}
