<?php

namespace Src\Auth\Presentation\Middlewares;

use Closure;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Auth\Domain\Exceptions\CustomerValidationException;
use Src\Customer\Application\GetCustomer;
use Src\Customer\Domain\ValueObjects\Email;
use Src\Infrastructure\Auth\JWTToken;
use Src\Infrastructure\Exceptions\InvalidCustomerException;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly GetCustomer $getCustomer
    ) {
    }

    public function handle(Request $request, Closure $next): Closure|JsonResponse
    {
        /** @var string $tokenHeader */
        $tokenHeader = $request->header('Authorization');

        if (! $tokenHeader) {
            return $this->response->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        $token = JWTToken::decode($tokenHeader);

        try {
            $email = new Email($token['email']);

            $customer = $this->getCustomer->byEmail($email);
        } catch (InvalidCustomerException|CustomerValidationException) {
            return $this->response->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        $request->setUserResolver(fn () => $customer);

        return $next($request);
    }
}
