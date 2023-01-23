<?php

namespace Src\Infrastructure\Clients;

use Src\Infrastructure\Clients\Enums\Method;
use Src\Infrastructure\Clients\Exceptions\InvalidURIException;
use Src\Infrastructure\Clients\Exceptions\RequestException;
use Src\Infrastructure\Clients\ValueObjects\JsonResponse;
use Src\Infrastructure\Clients\ValueObjects\URI;

class AuthorizerClient extends BaseClient
{
    /**
     * @throws RequestException
     * @throws InvalidURIException
     */
    public function authorize(): JsonResponse
    {
        /** @var string $configUri */
        $configUri = config('transactions.authorizer.uri');

        $uri = new URI($configUri);

        return $this->send(Method::GET, new URI($uri));
    }
}
