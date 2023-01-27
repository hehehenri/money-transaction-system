<?php

namespace Src\Transaction\Domain\ValueObjects;

enum TransactionType: string
{
    case SENT = 'sent';
    case RECEIVED = 'received';
}
