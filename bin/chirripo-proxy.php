<?php
if (\file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
} elseif (\file_exists(__DIR__ . '/../../../autoload.php')) {
    require_once __DIR__ . '/../../../autoload.php';
}

use Symfony\Component\Console\Application;
use Console\App\Commands\ProxyUpCommand;
use Console\App\Commands\ProxyDownCommand;

/**
 * Chirripo proxy version.
 */
function chirripo_proxy_version() {
    return '1.3';
}

/**
 * Chirripo proxy entrypoint.
 */
function chirripo_proxy_main() {
    $app = new Application();
    $app->setName('Chirripo Proxy Tool');
    $app->add(new ProxyUpCommand());
    $app->add(new ProxyDownCommand());

    $app->run();
}