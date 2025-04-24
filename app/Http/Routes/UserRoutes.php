<?php

namespace App\Http\Routes;

use App\Http\Controllers\UserController;
use Illuminate\Routing\Router;

class UserRoutes implements RouterInterface
{
    public static function routes(Router $api): void
    {
        $api->post('register', [UserController::class, 'register']);
    }
}
