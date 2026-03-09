#!/usr/bin/env php
<?php

require_once __DIR__ . '/src/EventListenerInterface.php';
require_once __DIR__ . '/src/EventListenerA.php';
require_once __DIR__ . '/src/EventDispatcher.php';
require_once __DIR__ . '/src/Event.php';

$eventDispatcher = new EventDispatcher();

$eventDispatcher->addListener(Event::class, function() {
    echo 'from anonymous function' . PHP_EOL;
});
$eventDispatcher->addListener(Event::class, new class implements EventListenerInterface {
    public function handle(object $event): void
    {
        echo 'from anonymous class (event listener interface)' . PHP_EOL;
    }
});
$eventDispatcher->addListener(Event::class, new EventListenerA());
$eventDispatcher->addListener('plop', function() {
    echo 'should not be called' . PHP_EOL;
});

$eventDispatcher->dispatch(new Event());
