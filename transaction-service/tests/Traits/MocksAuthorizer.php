<?php

namespace Tests\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Testing\Concerns\InteractsWithContainer;
use Illuminate\Support\Facades\Config;
use Mockery;
use Src\Infrastructure\Clients\BaseClient;
use Src\Transactions\Domain\Entities\Transaction;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

trait MocksAuthorizer
{
    use InteractsWithContainer;

    public function refuse(): void
    {
        $url = 'https://www.invalid-url.authorizer.com/';

        Config::set('transactions.authorizer.uri', $url);

        $client = Mockery::mock(Client::class);
        $client->shouldReceive('request')
            ->with('GET', $url)
            ->andReturn(new Response(status: HttpResponse::HTTP_FORBIDDEN));

        $this->instance(Client::class, $client);
    }

    public function authorize(): void
    {
        $url = 'https://www.invalid-url.authorizer.com/';

        Config::set('transactions.authorizer.uri', $url);

        $client = Mockery::mock(Client::class);
        $client->shouldReceive('request')
            ->with('GET', $url)
            ->andReturn(new Response(status: HttpResponse::HTTP_OK));

        $this->instance(Client::class, $client);
    }
}
