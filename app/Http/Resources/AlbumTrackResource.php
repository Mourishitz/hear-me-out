<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class AlbumTrackResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $this->resource = (object) $this->resource;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'track_number' => $this->track_number,
            'duration_ms' => $this->duration_ms,
            'explicit' => $this->explicit,
            'artists' => Arr::map($this->artists, function ($artist) {
                return [
                    'id' => $artist['id'],
                    'name' => $artist['name'],
                ];
            }),
        ];
    }
}
