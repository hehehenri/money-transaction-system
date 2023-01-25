<?php

namespace Src\Infrastructure\Clients\Http\CircuitBreaker;

enum State: string
{
    case OPEN = 'open';
    case HALF_OPEN = 'half-open';
    case CLOSED = 'closed';
}
