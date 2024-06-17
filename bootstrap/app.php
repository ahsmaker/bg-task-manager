<?php

use App\Exceptions\InvalidCredentialsException;
use App\Exceptions\TaskCategoryNotFoundException;
use App\Exceptions\TaskNotFoundException;
use App\Exceptions\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function(Middleware $middleware){
        //
    })
    ->withExceptions(function(Exceptions $exceptions){
        $exceptions->render(function(Exception $e, Request $request){
            // custom exceptions for API
            if($request->expectsJson()) {
                if($e instanceof TaskNotFoundException ||
                    $e instanceof TaskCategoryNotFoundException ||
                    $e instanceof ValidationException ||
                    $e instanceof InvalidCredentialsException
                ) {
                    return response()->json(['message' => $e->getMessage()], $e->getCode());
                }
            }

            return $e;
        });
    })->create();
