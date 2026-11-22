<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

// Pastikan semua direktori /tmp/storage ada untuk cache, view compile, sessions, dan logs
$storagePaths = [
    '/tmp/storage',
    '/tmp/storage/app',
    '/tmp/storage/app/public',
    '/tmp/storage/framework',
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
];

foreach ($storagePaths as $path) {
    if (!is_dir($path)) {
        mkdir($path, 0755, true);
    }
}

try {
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    http_response_code(500);
    echo "<div style='font-family:monospace;padding:24px;background:#1e1e2e;color:#f38ba8;'>";
    echo "<h2>Fatal Startup Error:</h2>";
    echo "<p><b>" . get_class($e) . ": " . htmlspecialchars($e->getMessage()) . "</b></p>";
    echo "<p>File: " . htmlspecialchars($e->getFile()) . ":" . $e->getLine() . "</p>";
    echo "<pre style='background:#111;color:#fff;padding:10px;'>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    echo "</div>";
    exit(1);
}
