<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class AlbumResource extends JsonResource
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
            'album_type' => $this->album_type,
            'total_tracks' => $this->total_tracks,
            'release_date' => $this->release_date,
            'artists' => Arr::map($this->artists, function ($artist) {
                return [
                    'id' => $artist['id'],
                    'name' => $artist['name'],
                ];
            }),
            'images' => [
                'small' => $this->images[2]['url'] ?? null,
                'medium' => $this->images[1]['url'] ?? null,
                'large' => $this->images[0]['url'] ?? null,
            ],
        ];
    }
}
