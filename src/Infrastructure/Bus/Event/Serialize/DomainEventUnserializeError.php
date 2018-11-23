<?php

declare(strict_types = 1);

namespace CodelyTv\Infrastructure\Bus\Event\Serialize;

use CodelyTv\Shared\Domain\DomainError;

final class DomainEventUnserializeError extends DomainError
{
    private $originalMessage;

    public function __construct(string $originalMessage)
    {
        $this->originalMessage = $originalMessage;

        parent::__construct();
    }

    public function originalMessage()
    {
        return $this->originalMessage;
    }

    public function errorCode(): string
    {
        return 'domain_event_unserialize_error';
    }

    protected function errorMessage(): string
    {
        return sprintf("The message <%s> couldn't be unserialized", $this->message);
    }
}
