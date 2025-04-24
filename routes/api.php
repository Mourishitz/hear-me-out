<?php

use App\Http\Routes\AlbumRoutes;
use App\Http\Routes\ArtistRoutes;
use App\Http\Routes\JWTRoutes;
use App\Http\Routes\UserRoutes;
use App\Providers\RouteFactory;

$router = new RouteFactory;
$router->registerRoutes([
    JWTRoutes::class,
    UserRoutes::class,
    ArtistRoutes::class,
    AlbumRoutes::class,
]);
