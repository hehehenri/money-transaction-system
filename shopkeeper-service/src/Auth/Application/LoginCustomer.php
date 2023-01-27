<?php

namespace Src\Auth\Application;

use Src\Auth\Application\Exceptions\ShopkeeperValidationException;
use Src\Auth\Domain\Exceptions\InvalidTokenException;
use Src\Auth\Domain\ValueObjects\Token;
use Src\Shopkeeper\Domain\Exceptions\ShopkeeperRepositoryException;
use Src\Shopkeeper\Domain\Repositories\ShopkeeperRepository;
use Src\Shopkeeper\Presentation\Rest\ViewModels\Auth\LoginViewModel;
use Src\Infrastructure\Auth\Authenticator;
use Src\Infrastructure\Exceptions\AuthenticationException;

class LoginShopkeeper
{
    public function __construct(
        private readonly ShopkeeperRepository $ShopkeeperRepository,
        private readonly Authenticator $auth,
    ) {
    }

    /**
     * @throws ShopkeeperValidationException
     * @throws AuthenticationException
     * @throws ShopkeeperRepositoryException
     * @throws InvalidTokenException
     */
    public function handle(LoginViewModel $payload): Token
    {
        $Shopkeeper = $this->ShopkeeperRepository->findByEmail($payload->email);

        if (! $Shopkeeper) {
            throw ShopkeeperValidationException::ShopkeeperEmailNotFound($payload->email);
        }

        return $this->auth->login($Shopkeeper, $payload->password);
    }
}
