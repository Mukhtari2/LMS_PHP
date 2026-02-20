<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
   ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
            'teacher' => \App\Http\Middleware\IsTeacher::class,
    ]);
    })

    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (NotFoundHttpException $exception, Request $request){
            if($request->is('api/*')){
                return response()->json([
                    'status' => 'error',
                    'message' => 'The requested resource was not found'
                ], 404);
            }
        });


        $exceptions->render(function (AccessDeniedHttpException $exception, Request $request){
            if($request->is('api/*')){    
                return response()->json([
                        'status' => 'error',
                        'message' => 'You do not have permission to access this resource.'
                ], 403);
            }
        });

    
        $exceptions->shouldRenderJsonWhen(function (Request $request, Throwable $e) {
            return $request->is('api/*') || $request->expectsJson();
        });
    }) ->create();
