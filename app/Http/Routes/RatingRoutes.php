<?php

namespace App\Http\Routes;

use App\Http\Controllers\RatingController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Routing\Router;

class RatingRoutes implements RouterInterface
{
    public static function routes(Router $api): void
    {
        $api->group(['prefix' => 'ratings'], function (Router $router) {
            $router->post('/{id}/like', [RatingController::class, 'like']);
            $router->delete('/{id}/like', [RatingController::class, 'unlike']);
            $router->put('/{id}', [RatingController::class, 'update'])->can('update', 'rating');
            $router->delete('/{id}', [RatingController::class, 'delete'])->can('delete', 'rating');
        })->middleware([JwtMiddleware::class]);

        $api->get('/ratings/{id}', [RatingController::class, 'getById']);
    }
}
