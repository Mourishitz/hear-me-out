<?php

namespace App\Http\Routes;

use App\Http\Controllers\ArtistController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Routing\Router;

class ArtistRoutes implements RouterInterface
{
    public static function routes(Router $api): void
    {
        $api->group(['prefix' => 'artists'], function (Router $router) {
            $router->get('/', [ArtistController::class, 'index']);
            $router->get('/{id}', [ArtistController::class, 'getbyId']);
            $router->get('/{id}/tracks', [ArtistController::class, 'getTracksByArtistId']);
            $router->get('/{id}/albums', [ArtistController::class, 'getAlbumsByArtistId']);

            $router->post('/{id}/rating', [ArtistController::class, 'rateArtist'])->middleware([JwtMiddleware::class]);
        });
    }
}
