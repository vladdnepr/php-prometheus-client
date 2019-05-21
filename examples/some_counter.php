<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Prometheus\Registry\CollectorRegistry;

$adapter = $_GET['adapter'];

if ($adapter === 'redis') {
    $redis_client = new Redis();
    $redis_client->connect($_SERVER['REDIS_HOST'] ?? '127.0.0.1');
    $adapter = new Prometheus\Storage\Redis($redis_client);
} elseif ($adapter === 'apcu') {
    $adapter = new Prometheus\Storage\APCU();
} elseif ($adapter === 'in-memory') {
    $adapter = new Prometheus\Storage\InMemory();
}
$registry = new CollectorRegistry($adapter);

$counter = $registry->registerCounter('test', 'some_counter', 'it increases', ['type']);
$counter->incBy((int) $_GET['c'], ['blue']);

echo "OK\n";
