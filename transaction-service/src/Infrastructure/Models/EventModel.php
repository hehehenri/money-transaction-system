<?php

namespace Src\Infrastructure\Models;

use Carbon\Carbon;
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

        return $type->intoEntity(
            new EventId($this->id),
            $this->payload,
            $this->processed_at,
            $this->created_at
        );
    }
}
