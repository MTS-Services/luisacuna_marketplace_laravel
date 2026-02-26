<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\AdminVerifyMiddleware;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\EnsureAdminNotBanned;
use App\Http\Middleware\EnsureUserNotBanned;
use App\Http\Middleware\PaymentSecurityMiddleware;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\SellerMiddleware;
use App\Http\Middleware\UserVerifyMiddleware;
use App\Http\Middleware\SetLocaleMiddleware as MultiLangSet;
use App\Http\Middleware\ValidateDeviceSession;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        channels: __DIR__ . '/../routes/channels.php',
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->trustProxies(at: '*', headers: Request::HEADER_X_FORWARDED_FOR | Request::HEADER_X_FORWARDED_PROTO);
        $middleware->alias([
            'auth' => Authenticate::class,
            'admin' => AdminMiddleware::class,
            'adminVerify' => AdminVerifyMiddleware::class,
            'userVerify' => UserVerifyMiddleware::class,
            'adminNotBanned' => EnsureAdminNotBanned::class,
            'userNotBanned' => EnsureUserNotBanned::class,
            'role' => RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class,
            'paymentSecurity' => PaymentSecurityMiddleware::class,
            'guest' => RedirectIfAuthenticated::class, //RedirectIfAuthenticated::class
            'seller' => SellerMiddleware::class,
        ]);
        $middleware->web(append: [
            MultiLangSet::class,
            \App\Http\Middleware\ValidateSessionExists::class,
        ]);
        $middleware->api(append: [MultiLangSet::class]);


        // $middleware->appendToGroup('web', [
        //     ValidateDeviceSession::class,
        // ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
