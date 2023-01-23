<?php

namespace Src\Infrastructure\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Log;
use Src\Customer\Domain\Entities\Customer;
use Src\Customer\Domain\InvalidParameterException as CustomerInvalidParameterException;
use Src\Customer\Domain\ValueObjects\CPF;
use Src\Infrastructure\Exceptions\InvalidCustomerException;
use Src\Infrastructure\Factories\CustomerFactory;
use Src\Shared\ValueObjects\Uuid;
use Src\User\Domain\Exceptions\UserValidationException as UserInvalidParameterException;
use Src\User\Domain\ValueObjects\Email;
use Src\User\Domain\ValueObjects\FullName;
use Src\User\Domain\ValueObjects\HashedPassword;

/**
 * @property string $id
 * @property string $full_name
 * @property string $email
 * @property string $document
 * @property string $password
 */
class CustomerModel extends Model
{
    use HasUuids, HasFactory;

    protected $table = 'customers';

    protected $fillable = [
        'id',
        'full_name',
        'email',
        'email_verified_at',
        'document',
        'password',
    ];

    protected $hidden = [
        'document',
        'password',
    ];

    public function tokens(): MorphMany
    {
        return $this->morphMany(TokenModel::class, 'tokenable');
    }

    protected static function newFactory(): CustomerFactory
    {
        return new CustomerFactory();
    }

    /** @throws InvalidCustomerException */
    public function intoEntity(): Customer
    {
        try {
            return new Customer(
                new Uuid($this->id),
                new FullName($this->full_name),
                new CPF($this->document),
                new Email($this->email),
                new HashedPassword($this->password)
            );
        } catch (UserInvalidParameterException|CustomerInvalidParameterException $e) {
            $exception = InvalidCustomerException::failedToBuildCustomerFromDatabase(new Uuid($this->id));

            Log::error($exception->getMessage(), ['message' => $e->getMessage()]);

            throw $exception;
        }
    }
}
