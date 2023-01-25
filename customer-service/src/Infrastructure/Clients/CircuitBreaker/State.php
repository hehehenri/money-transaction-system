<?php

namespace Src\Infrastructure\Clients\CircuitBreaker;

enum State: string
{
    case OPEN = 'open';
    case HALF_OPEN = 'half-open';
    case CLOSED = 'closed';
}
