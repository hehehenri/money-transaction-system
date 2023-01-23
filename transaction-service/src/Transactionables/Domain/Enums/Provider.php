<?php

namespace Src\Transactionables\Domain\Enums;

enum Provider: string
{
    case CUSTOMERS = 'customers';
    case SHOPKEEPERS = 'shopkeepers';
}
