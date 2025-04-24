<?php

namespace App\Http\Controllers;

use App\Http\Resources\AlbumResource;
use App\Http\Resources\AlbumTrackResource;
use App\Providers\Integrators\SpotifyServiceProvider;
use Illuminate\Http\Request;

class AlbumsController extends Controller
{
    public function index(Request $request)
    {
        return AlbumResource::collection(
            SpotifyServiceProvider::getAlbums(
                query: $request->get('query'),
                limit: $request->get('limit') ?? 10,
            )
        );
    }

    public function getById(string $id)
    {
        return new AlbumResource(
            SpotifyServiceProvider::getAlbumById(id: $id)
        );
    }

    public function getAlbumTracks(string $id)
    {
        return AlbumTrackResource::collection(
            SpotifyServiceProvider::getAlbumTracks(id: $id)
        );
    }
}
