#!/usr/bin/env php
<?php

require_once __DIR__ . '/src/EventDispatcher.php';
require_once __DIR__ . '/src/Event.php';

$eventDispatcher = new EventDispatcher();

$eventDispatcher->addListener(Event::class, function() {
    echo Event::class . PHP_EOL;
});
$eventDispatcher->addListener('plop', function() {
    echo 'plop' . PHP_EOL;
});

$eventDispatcher->dispatch(new Event(), 'plop');
$eventDispatcher->dispatch(new Event());
