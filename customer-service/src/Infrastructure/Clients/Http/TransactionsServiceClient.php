<?php

namespace Src\Infrastructure\Clients\Http;

use Src\Infrastructure\Clients\Http\Exceptions\InvalidURLException;
use Src\Infrastructure\Clients\Http\ValueObjects\BaseUrl;

class TransactionsServiceClient extends BaseClient
{
    /** @throws InvalidURLException */
    public function __construct()
    {
        /** @var array<string, string> $config */
        $config = config('services.transactions');

        parent::__construct(new BaseUrl($config['base_url']), $config['service_name']);
    }
}
