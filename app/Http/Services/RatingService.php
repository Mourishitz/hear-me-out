<?php

namespace App\Http\Services;

use App\Enums\RatingCriteriaEnum;
use App\Models\Rating;
use Tymon\JWTAuth\Facades\JWTAuth;

class RatingService
{
    private Rating $model;

    private function __construct(Rating $rating)
    {
        $this->model = $rating;
    }

    public static function getModel(int $id): self
    {
        return new self(Rating::query()->findOrFail($id));
    }

    public static function newRating(int $value, string $notes, RatingCriteriaEnum $criteria): self
    {
        $rating = new Rating;
        $rating->value = $value;
        $rating->notes = $notes;
        $rating->criteria = $criteria->value;
        $rating->user()->associate(JWTAuth::user());

        return new self($rating);
    }

    public function forRatable(string $ratableType, string $ratableId): self
    {
        $this->model->ratable_type = $ratableType;
        $this->model->ratable_id = $ratableId;

        return $this;
    }

    public function delete(): bool
    {
        return $this->model->delete();
    }

    public function save(): Rating
    {
        $this->model->save();

        return $this->model;
    }
}
