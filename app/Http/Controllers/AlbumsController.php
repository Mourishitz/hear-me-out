<?php

namespace App\Http\Controllers;

use App\Enums\RatingCriteriaEnum;
use App\Enums\SpotifyModelTypeEnum;
use App\Http\Requests\StoreRatingRequest;
use App\Http\Resources\AlbumResource;
use App\Http\Resources\AlbumTrackResource;
use App\Http\Resources\RatingResource;
use App\Http\Services\RatingService;
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

    public function rateAlbum(string $id, StoreRatingRequest $request)
    {
        return new RatingResource(RatingService::newRating(
            value: $request->get('value'),
            notes: $request->get('notes'),
            criteria: RatingCriteriaEnum::getByName($request->get('criteria')),
        )
            ->forRatable(SpotifyModelTypeEnum::ALBUM->name, $id)
            ->save()
        );
    }
}
