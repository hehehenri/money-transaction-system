<?php

namespace Src\Customer\Application;

use Src\Customer\Domain\Enums\Status;
use Src\Customer\Domain\Repositories\CustomerRepository;
use Src\Customer\Domain\ValueObjects\CustomerId;

class UpdateCustomerStatus
{
    public function __construct(private readonly CustomerRepository $repository)
    {
    }

    public function handle(CustomerId $id, Status $status): void
    {
        $this->repository->updateStatus($id, $status);
    }
}
