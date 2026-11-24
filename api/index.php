<?php

$isDebug = filter_var(getenv('APP_DEBUG') ?: false, FILTER_VALIDATE_BOOLEAN);
error_reporting($isDebug ? E_ALL : E_ALL & ~E_DEPRECATED & ~E_STRICT);
ini_set('display_errors', $isDebug ? '1' : '0');

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
    if (! is_dir($path)) {
        mkdir($path, 0755, true);
    }
}

try {
    require __DIR__.'/../public/index.php';
} catch (\Throwable $e) {
    error_log('[SatuJarak Fatal Startup] '.get_class($e).': '.$e->getMessage().' in '.$e->getFile().':'.$e->getLine());
    http_response_code(500);
    if ($isDebug) {
        echo "<div style='font-family:monospace;padding:24px;background:#1e1e2e;color:#f38ba8;'>";
        echo '<h2>Fatal Startup Error:</h2>';
        echo '<p><b>'.get_class($e).': '.htmlspecialchars($e->getMessage()).'</b></p>';
        echo '<p>File: '.htmlspecialchars($e->getFile()).':'.$e->getLine().'</p>';
        echo "<pre style='background:#111;color:#fff;padding:10px;'>".htmlspecialchars($e->getTraceAsString()).'</pre>';
        echo '</div>';
    } else {
        echo 'Terjadi kesalahan pada server. Silakan coba beberapa saat lagi.';
    }
    exit(1);
}
