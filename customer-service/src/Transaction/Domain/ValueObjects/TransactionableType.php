<?php

namespace Src\Transaction\Domain\ValueObjects;

enum TransactionableType: string
{
    case CUSTOMER = 'customer';
    case SHOPKEEPER = 'shopkeeper';
}
