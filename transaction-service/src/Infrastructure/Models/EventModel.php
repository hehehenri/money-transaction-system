<?php

namespace Src\Infrastructure\Models;

use Carbon\Carbon;
use Database\Factories\EventFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Src\Infrastructure\Events\DTOs\EventDTO;
use Src\Infrastructure\Events\Entities\Event;
use Src\Infrastructure\Events\Exceptions\InvalidEventTypeException;
use Src\Infrastructure\Events\Exceptions\InvalidPayloadException;
use Src\Infrastructure\Events\ValueObjects\EventId;
use Src\Infrastructure\Events\ValueObjects\EventType;

/**
 * @extends Model<Event>
 *
 * @property string $id
 * @property string $type
 * @property string $payload
 * @property Carbon $processed_at
 * @property Carbon $created_at
 */
class EventModel extends Model
{
    use HasUuids, HasFactory;

    public $table = 'events';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'type',
        'payload',
        'processed_at',
        'created_at',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'processed_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    /**
     * @throws InvalidEventTypeException
     * @throws InvalidPayloadException
     */
    public function intoEntity(): Event
    {
        $type = EventType::tryFrom($this->type);

        if (! $type) {
            throw InvalidEventTypeException::cannotDeserializeFromType($this->type);
        }

        return $type->intoEntity(new EventDTO(
            new EventId($this->id),
            $this->payload,
            $type,
            $this->processed_at,
            $this->created_at
        ));
    }

    protected static function newFactory(): EventFactory
    {
        return new EventFactory();
    }
}
