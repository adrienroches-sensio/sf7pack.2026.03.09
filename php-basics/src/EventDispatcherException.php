<?php

class EventDispatcherException extends \Exception
{
    public static function noListenersForEvent(string $eventName): self
    {
        return new self("No listeners for event '{$eventName}'.");
    }
}
