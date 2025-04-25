<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class TrackResource extends JsonResource
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
            'popularity' => $this->popularity,
            'duration_ms' => $this->duration_ms,
            'explicit' => $this->explicit,
            'album' => [
                'id' => $this->album['id'],
                'name' => $this->album['name'],
                'release_date' => $this->album['release_date'],
                'total_tracks' => $this->album['total_tracks'],
                'images' => [
                    'small' => $this->album['images'][2]['url'] ?? null,
                    'medium' => $this->album['images'][1]['url'] ?? null,
                    'large' => $this->album['images'][0]['url'] ?? null,
                ],
            ],
            'artists' => Arr::map($this->artists, function ($artist) {
                return [
                    'id' => $artist['id'],
                    'name' => $artist['name'],
                ];
            }),
        ];
    }
}
