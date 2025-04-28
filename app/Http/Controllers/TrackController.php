<?php

namespace App\Http\Controllers;

use App\Enums\RatingCriteriaEnum;
use App\Enums\SpotifyModelTypeEnum;
use App\Http\Resources\RatingResource;
use App\Http\Resources\TrackResource;
use App\Http\Services\RatingService;
use App\Providers\Integrators\SpotifyServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TrackController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        return TrackResource::collection(SpotifyServiceProvider::getTracks(query: $request->get('query'), limit: $request->get('limit') ?? 10));
    }

    public function getById(string $id): TrackResource
    {
        return new TrackResource(SpotifyServiceProvider::getTrackById(id: $id));
    }

    public function rateTrack(string $id, Request $request): RatingResource
    {
        return new RatingResource(RatingService::newRating(
            value: $request->get('value'),
            notes: $request->get('notes'),
            criteria: RatingCriteriaEnum::getByName($request->get('criteria')),
        )
            ->forRatable(SpotifyModelTypeEnum::TRACK->name, $id)
            ->save()
        );
    }
}
