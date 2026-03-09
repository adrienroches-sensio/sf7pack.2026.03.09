<?php

class EventDispatcher
{
    private array $listeners = [];

    public function dispatch(object $event, string|null $eventName = null): object
    {
        $eventName ??= $event::class;

        $listeners = $this->getListenersForEvent($eventName);

        foreach ($listeners as $listener) {
            $listener($event);
        }

        return $event;
    }

    public function addListener(string $eventName, callable $listener): void
    {
        $this->listeners[$eventName] ??= [];
        $this->listeners[$eventName][] = $listener;
    }

    private function getListenersForEvent(string $eventName): array
    {
        return $this->listeners[$eventName] ?? [];
    }
}
