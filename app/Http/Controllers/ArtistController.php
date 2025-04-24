<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArtistResource;
use App\Http\Resources\ArtistTrackResource;
use App\Providers\Integrators\SpotifyServiceProvider;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    public function index(Request $request)
    {
        return ArtistResource::collection(SpotifyServiceProvider::getArtists(query: $request->get('query'), limit: $request->get('limit') ?? 10));
    }

    public function getById(string $id)
    {
        return new ArtistResource(SpotifyServiceProvider::getArtistById(id: $id));
    }

    public function getTracksByArtistId(string $id)
    {
        return ArtistTrackResource::collection(SpotifyServiceProvider::getTracksByArtistId(id: $id));
    }
}
