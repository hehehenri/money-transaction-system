<?php

namespace Src\Infrastructure\Clients\Http\TransactionsService\Responses\GetTransactionsResponse;

use Psr\Http\Message\ResponseInterface;
use Src\Infrastructure\Clients\Http\TransactionsService\Responses\Response;
use Src\Shared\ValueObjects\Money;
use Src\Transaction\Domain\ValueObjects\TransactionableId;
use Src\Transaction\Domain\ValueObjects\TransactionId;

class GetTransactionsResponse implements Response
{
    /** @param  array<TransactionResponse>  $transactions */
    public function __construct(
        public readonly array $transactions,
        public readonly int $perPage,
        public readonly int $page
    ) {
    }

    public static function deserialize(ResponseInterface $jsonResponse): Response
    {
        /**
         * @var array{
         *          transactions: array<array{
         *              id: string,
         *              sender_id: string,
         *              receiver_id: string,
         *              amount: int
         *          }>,
         *          per_page: int,
         *          page: int
         *      } $response
         */
        $response = json_decode($jsonResponse->getBody(), true);

        $transactions = [];

        foreach ($response['transactions'] as $transaction) {
            $transactions[] = new TransactionResponse(
                new TransactionId($transaction['id']),
                new TransactionableId($transaction['sender_id']),
                new TransactionableId($transaction['receiver_id']),
                new Money($transaction['amount']),
            );
        }

        return new self($transactions, $response['per_page'], $response['page']);
    }

    /**
     * @return array{
     *          transactions: array<array{id: string, sender_id: string, receiver_id: string,amount: int}>,
     *          per_page: int,
     *          page: int
     *      } $response
     */
    public function serialize(): array
    {
        $transactions = [];

        foreach ($this->transactions as $transaction) {
            $transactions[] = [
                'id' => (string) $transaction->id,
                'sender_id' => (string) $transaction->sender,
                'receiver_id' => (string) $transaction->receiver,
                'amount' => $transaction->money->value(),
            ];
        }

        return [
            'transactions' => $transactions,
            'per_page' => $this->perPage,
            'page' => $this->page,
        ];
    }
}
