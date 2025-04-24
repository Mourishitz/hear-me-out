<?php

namespace App\Http\Routes;

use App\Http\Controllers\JWTAuthController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Routing\Router;

class JWTRoutes implements RouterInterface
{
    public static function routes(Router $api): void
    {
        $api->post('login', [JWTAuthController::class, 'login']);

        $api->middleware([JwtMiddleware::class])->group(function (Router $sub) {
            $sub->get('user', [JWTAuthController::class, 'getUser']);
            $sub->post('logout', [JWTAuthController::class, 'logout']);
        });
    }
}
