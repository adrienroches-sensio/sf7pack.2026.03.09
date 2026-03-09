<?php

class EventDispatcher
{
    /**
     * @var array<string, (callable|EventListenerInterface)[]>
     */
    private array $listeners = [];

    public function dispatch(object $event, string|null $eventName = null): object
    {
        $eventName ??= $event::class;

        $listeners = $this->getListenersForEvent($eventName);

        foreach ($listeners as $listener) {
            if ($listener instanceof EventListenerInterface) {
                $listener->handle($event);
                continue;
            }

            $listener($event);
        }

        return $event;
    }

    public function addListener(string $eventName, callable|EventListenerInterface $listener): void
    {
        $this->listeners[$eventName] ??= [];
        $this->listeners[$eventName][] = $listener;
    }

    /**
     * @throws EventDispatcherException If no listeners are registered for the given event.
     */
    private function getListenersForEvent(string $eventName): array
    {
        return $this->listeners[$eventName] ?? throw EventDispatcherException::noListenersForEvent($eventName);
    }
}
