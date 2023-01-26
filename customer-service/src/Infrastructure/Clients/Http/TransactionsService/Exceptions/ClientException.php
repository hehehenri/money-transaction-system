<?php

namespace Src\Infrastructure\Clients\Http\TransactionsService\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class ClientException extends Exception
{
    public static function failedToCommunicateWithService(Exception $e): self
    {
        Log::error('Client error: ', [
            'trace' => $e->getTrace(),
            'code' => $e->getCode(),
            'message' => $e->getMessage(),
        ]);

        return new self('Failed to communicate with services.');
    }
}
