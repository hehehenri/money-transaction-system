<?php

namespace Src\Transactions\Domain\Enums;

enum TransactionStatus: string
{
    case PENDING = 'pending';
    case SUCCESS = 'success';
    case REFUSED = 'refused';
    case CANCELLED = 'cancelled';
}
