<?php

namespace Src\Infrastructure\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Src\Shopkeeper\Domain\Entities\Shopkeeper;
use Src\Shopkeeper\Domain\Enums\Status;
use Src\Shopkeeper\Domain\ValueObjects\CPF;
use Src\Shopkeeper\Domain\ValueObjects\ShopkeeperId;
use Src\Shopkeeper\Domain\ValueObjects\Email;
use Src\Shopkeeper\Domain\ValueObjects\FullName;
use Src\Shopkeeper\Domain\ValueObjects\HashedPassword;
use Src\Infrastructure\Exceptions\InvalidShopkeeperException;
use Src\Infrastructure\Factories\ShopkeeperFactory;
use Src\Shared\ValueObjects\Uuid;

/**
 * @property string $id
 * @property string $full_name
 * @property string $email
 * @property string $document
 * @property string $password
 * @property string $status
 */
class ShopkeeperModel extends Model
{
    use HasUuids, HasFactory;

    protected $table = 'Shopkeepers';

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
        return $this->hasMany(TokenModel::class, 'Shopkeeper_id');
    }

    protected static function newFactory(): ShopkeeperFactory
    {
        return new ShopkeeperFactory();
    }

    /**
     * @throws InvalidShopkeeperException
     */
    public function intoEntity(): Shopkeeper
    {
        $status = Status::tryFrom($this->status);

        if (! $status) {
            throw InvalidShopkeeperException::failedToBuildShopkeeperFromDatabase(new Uuid($this->id));
        }

        try {
            return new Shopkeeper(
                new ShopkeeperId($this->id),
                new Email($this->email),
                new HashedPassword($this->password),
                new FullName($this->full_name),
                new CPF($this->document),
                $status
            );
        } catch (\Exception) {
            throw InvalidShopkeeperException::failedToBuildShopkeeperFromDatabase($this->id);
        }
    }
}
