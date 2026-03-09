<?php

class EventListenerA implements EventListenerInterface
{
    public function handle(object $event): void
    {
        echo 'coucou from ' . self::class . PHP_EOL;
    }
}
