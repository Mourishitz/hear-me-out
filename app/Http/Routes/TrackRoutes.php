<?php

namespace App\Http\Routes;

use App\Http\Controllers\TrackController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Routing\Router;

class TrackRoutes implements RouterInterface
{
    public static function routes(Router $api): void
    {
        $api->group(['prefix' => 'tracks'], function (Router $router) {
            $router->get('/', [TrackController::class, 'index']);
            $router->get('/{id}', [TrackController::class, 'getbyId']);

            $router->post('/{id}/rating', [TrackController::class, 'rateTrack'])->middleware([JwtMiddleware::class]);
        });
    }
}
