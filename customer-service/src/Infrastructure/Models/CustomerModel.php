<?php

namespace Src\Infrastructure\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Src\Customer\Domain\Entities\Customer;
use Src\Customer\Domain\Enums\Status;
use Src\Customer\Domain\ValueObjects\CPF;
use Src\Customer\Domain\ValueObjects\CustomerId;
use Src\Customer\Domain\ValueObjects\Email;
use Src\Customer\Domain\ValueObjects\FullName;
use Src\Customer\Domain\ValueObjects\HashedPassword;
use Src\Infrastructure\Exceptions\InvalidCustomerException;
use Src\Infrastructure\Factories\CustomerFactory;
use Src\Shared\ValueObjects\Uuid;

/**
 * @property string $id
 * @property string $full_name
 * @property string $email
 * @property string $document
 * @property string $password
 * @property string $status
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
        'status',
    ];

    protected $hidden = [
        'document',
        'password',
    ];

    public function tokens(): HasMany
    {
        return $this->hasMany(TokenModel::class, 'customer_id');
    }

    protected static function newFactory(): CustomerFactory
    {
        return new CustomerFactory();
    }

    /**
     * @throws InvalidCustomerException
     */
    public function intoEntity(): Customer
    {
        $status = Status::tryFrom($this->status);

        if (! $status) {
            throw InvalidCustomerException::failedToBuildCustomerFromDatabase(new Uuid($this->id));
        }

        try {
            return new Customer(
                new CustomerId($this->id),
                new Email($this->email),
                new HashedPassword($this->password),
                new FullName($this->full_name),
                new CPF($this->document),
                $status
            );
        } catch (\Exception) {
            throw InvalidCustomerException::failedToBuildCustomerFromDatabase($this->id);
        }
    }
}
