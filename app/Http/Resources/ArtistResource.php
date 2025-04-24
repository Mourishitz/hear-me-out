<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArtistResource extends JsonResource
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
            'genres' => $this->genres,
            'image' => $this->images[0]['url'] ?? null,
            'popularity' => $this->popularity,
            'followers' => $this->followers['total'] ?? 0,
        ];
    }
}
