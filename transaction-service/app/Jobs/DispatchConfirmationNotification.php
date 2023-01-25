<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Src\Infrastructure\Clients\Http\Exceptions\InvalidURIException;
use Src\Infrastructure\Clients\Http\Exceptions\RequestException;
use Src\Infrastructure\Clients\Http\Exceptions\ResponseException;
use Src\Infrastructure\Clients\Http\NotificationClient;
use Src\Transactionables\Domain\Entities\Transactionable;

class DispatchConfirmationNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly Transactionable $transactionable)
    {
    }

    /**
     * @throws RequestException
     * @throws InvalidURIException
     * @throws ResponseException
     */
    public function handle(NotificationClient $client)
    {
        $client->send($this->transactionable);
    }
}
