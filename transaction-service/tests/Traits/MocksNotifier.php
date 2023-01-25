<?php

namespace Tests\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Testing\Concerns\InteractsWithContainer;
use Illuminate\Support\Facades\Config;
use Mockery;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

trait MocksNotifier
{
    use InteractsWithContainer;

    public function notifyWithSuccess(): void
    {
        $url = 'https://www.invalid-url.notifier.com/';

        Config::set('transactions.notification.service_uri', $url);

        $client = Mockery::mock(Client::class);
        $client->shouldReceive('request')
            ->with('GET', $url)
            ->andReturn(new Response(status: HttpResponse::HTTP_OK));

        $this->instance(Client::class, $client);
    }

    public function notifyWithFailure(): void
    {
        $url = 'https://www.invalid-url.notifier.com/';

        Config::set('transactions.notification.service_uri', $url);

        $client = Mockery::mock(Client::class);
        $client->shouldReceive('request')
            ->with('GET', $url)
            ->andReturn(new Response(status: HttpResponse::HTTP_FORBIDDEN));

        $this->instance(Client::class, $client);
    }
}
