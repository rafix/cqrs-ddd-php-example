<?php

declare(strict_types = 1);

namespace CodelyTv\Infrastructure\Bus\Event\Serialize;

use CodelyTv\Infrastructure\Bus\Event\DomainEventMapping;
use CodelyTv\Shared\Domain\Bus\Event\DomainEvent;
use function CodelyTv\Utils\snake_to_camel;
use function Lambdish\Phunctional\get;
use function Lambdish\Phunctional\reindex;

final class DomainEventUnserializer
{
    private $eventMapping;

    public function __construct(DomainEventMapping $eventMapping)
    {
        $this->eventMapping = $eventMapping;
    }

    public function __invoke(string $serializedEvent): DomainEvent
    {
        $parsedEvent = json_decode($serializedEvent, true);

        $this->ensureHasValidFormat($parsedEvent, $serializedEvent);

        $eventName  = $parsedEvent['type'];
        $eventClass = $this->eventMapping->for($eventName);

        return new $eventClass(get('id', $parsedEvent), reindex($this->toCamel(), $parsedEvent));
    }

    private function toCamel()
    {
        return function ($unused, $key) {
            return snake_to_camel($key);
        };
    }

    private function ensureHasValidFormat($parsedEvent, string $serializedEvent)
    {
        if (!is_array($parsedEvent) || !isset($parsedEvent['type'])) {
            throw new DomainEventUnserializeError($serializedEvent);
        }
    }
}
