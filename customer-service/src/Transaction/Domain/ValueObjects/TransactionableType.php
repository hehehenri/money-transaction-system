<?php

namespace Src\Transaction\Domain\ValueObjects;

enum TransactionableType: string
{
    case CUSTOMER = 'customer';
    case SHOPKEEPER = 'shopkeeper';

    public function provider(): string
    {
        return match ($this) {
            self::CUSTOMER => 'customers',
            self::SHOPKEEPER => 'shopkeepers',
        };
    }
}
