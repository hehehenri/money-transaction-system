<?php

namespace Src\Shopkeeper\Domain\Enums;

enum Status: string
{
    case PENDING = 'pending';
    case ACTIVE = 'active';
}
