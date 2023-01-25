<?php

namespace Src\Infrastructure\Clients\Http\CircuitBreaker;

enum Key: string
{
    case OPEN = 'open';
    case HALF_OPEN = 'half-open';
    case ERRORS = 'errors';
    case SUCCESSES = 'successes';
}
