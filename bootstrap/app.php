<?php

use App\Http\Middleware\IsAdmin;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*');
        $middleware->web(append: ['cache.headers:no_store;private;max_age=0;must_revalidate']);

        $middleware->alias([
            'admin' => IsAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );

        $exceptions->render(function (\Throwable $e, Request $request) {
            return response(
                "<div style='font-family:monospace;padding:24px;background:#1e1e2e;color:#f38ba8;line-height:1.5;'>" .
                "<h2 style='color:#fab387;margin-top:0;'>⚠️ Laravel Error Detail:</h2>" .
                "<p style='font-size:18px;color:#f9e2af;'><b>" . get_class($e) . "</b>: " . htmlspecialchars($e->getMessage()) . "</p>" .
                "<p style='color:#a6adc8;'><b>In File:</b> " . htmlspecialchars($e->getFile()) . " : line " . $e->getLine() . "</p>" .
                "<details open><summary style='cursor:pointer;color:#89b4fa;'><b>Stack Trace</b></summary>" .
                "<pre style='background:#11111b;color:#cdd6f4;padding:12px;border-radius:6px;overflow-x:auto;font-size:13px;'>" .
                htmlspecialchars($e->getTraceAsString()) .
                "</pre></details></div>",
                500
            );
        });
    })->create();

if (isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL']) || env('VERCEL')) {
    $app->useStoragePath('/tmp/storage');
}

return $app;
