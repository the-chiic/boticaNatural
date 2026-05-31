<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Hosting en subcarpeta sin /public en la URL (lee APP_URL del .env)
// Comentado si el document root apunta a public/
$envFile = dirname(__DIR__) . DIRECTORY_SEPARATOR . '.env';
if (is_readable($envFile)) {
    $envContents = file_get_contents($envFile);
    if (preg_match('/^\s*APP_URL\s*=\s*["\']?([^"\'#\r\n]+)/m', $envContents, $matches)) {
        $base = rtrim(parse_url(trim($matches[1]), PHP_URL_PATH) ?: '', '/');
        $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
        if ($scriptDir === '/' || $scriptDir === '.') {
            $scriptDir = '';
        }

        $prefixes = array_values(array_unique(array_filter([
            $base !== '' && $base !== '/' ? $base . '/public' : null,
            $base !== '' && $base !== '/' ? $base : null,
            $scriptDir !== '' ? $scriptDir . '/public' : null,
            $scriptDir !== '' ? $scriptDir : null,
        ])));

        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        $path = parse_url($uri, PHP_URL_PATH) ?: '/';

        foreach ($prefixes as $prefix) {
            $prefix = rtrim($prefix, '/');
            if ($prefix === '') {
                continue;
            }
            if (strncasecmp($path, $prefix, strlen($prefix)) === 0) {
                $path = substr($path, strlen($prefix)) ?: '/';
                break;
            }
        }

        if ($path === '/index.php' || str_starts_with($path, '/index.php/')) {
            $path = substr($path, strlen('/index.php')) ?: '/';
        }

        $query = parse_url($uri, PHP_URL_QUERY);
        $_SERVER['REQUEST_URI'] = ($path === '' ? '/' : $path) . ($query ? '?' . $query : '');
    }
}

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
