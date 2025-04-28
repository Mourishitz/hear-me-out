<?php

namespace App\Http\Controllers;

use App\Enums\RatingCriteriaEnum;
use App\Enums\SpotifyModelTypeEnum;
use App\Http\Resources\AlbumResource;
use App\Http\Resources\ArtistResource;
use App\Http\Resources\ArtistTrackResource;
use App\Http\Resources\RatingResource;
use App\Http\Services\RatingService;
use App\Providers\Integrators\SpotifyServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ArtistController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        return ArtistResource::collection(SpotifyServiceProvider::getArtists(query: $request->get('query'), limit: $request->get('limit') ?? 10));
    }

    public function getById(string $id): ArtistResource
    {
        return new ArtistResource(SpotifyServiceProvider::getArtistById(id: $id));
    }

    public function getTracksByArtistId(string $id): AnonymousResourceCollection
    {
        return ArtistTrackResource::collection(SpotifyServiceProvider::getTracksByArtistId(id: $id));
    }

    public function getAlbumsByArtistId(string $id): AnonymousResourceCollection
    {
        return AlbumResource::collection(SpotifyServiceProvider::getAlbumsByArtistId(id: $id));
    }

    public function rateArtist(string $id, Request $request): RatingResource
    {
        return new RatingResource(RatingService::newRating(
            value: $request->get('value'),
            notes: $request->get('notes'),
            criteria: RatingCriteriaEnum::getByName($request->get('criteria')),
        )
            ->forRatable(SpotifyModelTypeEnum::ARTIST->name, $id)
            ->save()
        );
    }
}
