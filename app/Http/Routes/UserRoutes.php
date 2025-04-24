<?php

namespace App\Http\Routes;

use App\Http\Controllers\UserController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Routing\Router;

class UserRoutes implements RouterInterface
{
    public static function routes(Router $api): void
    {

        $api->group(['prefix' => 'users'], function (Router $router) {
            $router->get('/', [UserController::class, 'index']);
            $router->get('/me', [UserController::class, 'me']);

            $router->get('/followers', [UserController::class, 'getFollowers']);
            $router->get('/following', [UserController::class, 'getFollowing']);

            $router->get('/{id}', [UserController::class, 'show']);
            $router->post('/{id}/setSpotify', [UserController::class, 'setSpotify']);
            $router->post('/{id}/follow', [UserController::class, 'follow']);
            $router->delete('/{id}/unfollow', [UserController::class, 'unfollow']);
        })->middleware([JwtMiddleware::class]);

        $api->get('users/{id}/following', [UserController::class, 'getFollowing']);
        $api->get('users/{id}/followers', [UserController::class, 'getFollowers']);
        $api->post('register', [UserController::class, 'register']);
    }
}
