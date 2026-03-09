#!/usr/bin/env php
<?php

require_once __DIR__ . '/src/EventDispatcherException.php';
require_once __DIR__ . '/src/EventListenerInterface.php';
require_once __DIR__ . '/src/EventDispatcher.php';
require_once __DIR__ . '/src/Event.php';

$eventDispatcher = new EventDispatcher();

$eventDispatcher->addListener(Event::class, function() {
    echo 'from anonymous function' . PHP_EOL;
});

$eventDispatcher->dispatch(new class {}, 'anonymous');
