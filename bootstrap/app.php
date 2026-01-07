<?php

use App\Console\Commands\CreateUser;
use App\Console\Commands\GenerateCsv;
use App\Console\Commands\ProcessCsv;
use App\Console\Commands\TotalAmountUser;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withCommands([
        CreateUser::class,
        TotalAmountUser::class,
        GenerateCsv::class,
        ProcessCsv::class
    ])
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

