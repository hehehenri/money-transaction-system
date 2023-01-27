<?php

namespace Src\Infrastructure;

class TTL
{
    public static function fromDays(int $days): int
    {
        return 60 * 60 * 24 * $days;
    }
}
