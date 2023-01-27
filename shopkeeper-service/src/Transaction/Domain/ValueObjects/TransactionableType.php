<?php

namespace Src\Transaction\Domain\ValueObjects;

enum TransactionableType: string
{
    case Shopkeeper = 'Shopkeeper';
    case SHOPKEEPER = 'shopkeeper';

    public function provider(): string
    {
        return match ($this) {
            self::Shopkeeper => 'Shopkeepers',
            self::SHOPKEEPER => 'shopkeepers',
        };
    }
}
