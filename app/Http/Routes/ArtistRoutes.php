<?php

namespace App\Http\Routes;

use App\Http\Controllers\ArtistController;
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
        });
    }
}
