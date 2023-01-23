<?php

namespace Src\Infrastructure\Clients\CircuitBreaker;

enum State
{
    case OPEN;
    case HALF_OPEN;
    case CLOSED;
}
