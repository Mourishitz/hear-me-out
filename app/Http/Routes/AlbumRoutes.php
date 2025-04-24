<?php

namespace App\Http\Routes;

use App\Http\Controllers\AlbumsController;
use Illuminate\Routing\Router;

class AlbumRoutes implements RouterInterface
{
    public static function routes(Router $api): void
    {
        $api->group(['prefix' => 'albums'], function (Router $router) {
            $router->get('/', [AlbumsController::class, 'index']);
            $router->get('/{id}', [AlbumsController::class, 'getbyId']);
            $router->get('/{id}/tracks', [AlbumsController::class, 'getAlbumTracks']);
        });
    }
}
