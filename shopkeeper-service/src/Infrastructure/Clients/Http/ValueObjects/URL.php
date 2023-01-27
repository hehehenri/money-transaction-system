<?php

namespace Src\Infrastructure\Clients\Http\ValueObjects;

use Src\Infrastructure\Clients\Http\Constraints\RequestPayload;
use Src\Infrastructure\Clients\Http\Enums\Method;
use Src\Infrastructure\Clients\Http\Exceptions\InvalidURLException;
use Src\Infrastructure\Clients\Http\TransactionsService\Endpoint;
use Src\Shared\ValueObjects\StringValueObject;

class URL extends StringValueObject
{
    /** @throws InvalidURLException */
    public function __construct(string $value)
    {
        if (! filter_var($value, FILTER_VALIDATE_URL)) {
            throw InvalidURLException::wrongFormat($value);
        }

        parent::__construct($value);
    }

    /** @throws InvalidURLException */
    public static function build(Endpoint $endpoint, string $url, ?RequestPayload $payload = null): self
    {
        $url = trim($url, '/');
        $path = trim($endpoint->value, '/');

        if ($endpoint->method() === Method::GET) {
            if ($payload) {
                return new self(sprintf('%s/%s?%s', $url, $path, http_build_query($payload->jsonSerialize())));
            }

            return new self(sprintf('%s/%s', $url, $path));
        }

        return new self($url);
    }
}
