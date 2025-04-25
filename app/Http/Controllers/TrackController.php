<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArtistResource;
use App\Http\Resources\TrackResource;
use App\Providers\Integrators\SpotifyServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TrackController extends Controller
{
    public function index(Request $request)// : AnonymousResourceCollection
    {
        return TrackResource::collection(SpotifyServiceProvider::getTracks(query: $request->get('query'), limit: $request->get('limit') ?? 10));
    }

    public function getById(string $id)// : ArtistResource
    {
        return new TrackResource(SpotifyServiceProvider::getTrackById(id: $id));
    }
}
