<?php

namespace App\Providers\Integrators;

use App\Enums\SpotifyModelTypeEnum;
use App\Enums\SpotifyModulesEnum;
use App\Providers\Interfaces\SongProviderInterface;
use Illuminate\Support\Facades\App;

class SpotifyServiceProvider implements SongProviderInterface
{
    public static function getTracks(string $query = '', int $limit = 10): array
    {
        /**
         * @var \App\Providers\Integrators\Apis\Spotify $spotify
         */
        $spotify = App::get('Spotify');

        return $spotify->indexType(
            type: SpotifyModelTypeEnum::TRACK,
            limit: $limit,
            query: $query
        );
    }

    public static function getTrackById(string $id): array
    {
        /**
         * @var \App\Providers\Integrators\Apis\Spotify $spotify
         */
        $spotify = App::get('Spotify');

        return $spotify->findById(id: $id, module: SpotifyModulesEnum::TRACKS);
    }

    public static function getTrackByName(string $name): array
    {
        /**
         * @var \App\Providers\Integrators\Apis\Spotify $spotify
         */
        $spotify = App::get('Spotify');

        return $spotify->indexType(
            type: SpotifyModelTypeEnum::TRACK,
            limit: 10,
            query: $name
        );

    }

    public static function getArtistById(string $id): array
    {
        /**
         * @var \App\Providers\Integrators\Apis\Spotify $spotify
         */
        $spotify = App::get('Spotify');

        return $spotify->findById(id: $id, module: SpotifyModulesEnum::ARTISTS);
    }

    public static function getArtistByName(string $name): array
    {
        /**
         * @var \App\Providers\Integrators\Apis\Spotify $spotify
         */
        $spotify = App::get('Spotify');

        return $spotify->indexType(
            type: SpotifyModelTypeEnum::ARTIST,
            limit: 1,
            query: $name
        );
    }

    public static function getArtists(string $query, int $limit = 10): array
    {
        /**
         * @var \App\Providers\Integrators\Apis\Spotify $spotify
         */
        $spotify = App::get('Spotify');

        return $spotify->indexType(
            type: SpotifyModelTypeEnum::ARTIST,
            limit: $limit,
            query: $query
        );
    }

    public static function getTracksByArtistId(string $id): array
    {
        /**
         * @var \App\Providers\Integrators\Apis\Spotify $spotify
         */
        $spotify = App::get('Spotify');

        return $spotify->getRelationForId(
            entityId: $id,
            entityModule: SpotifyModulesEnum::ARTISTS,
            relationModule: SpotifyModulesEnum::TOP_TRACKS
        )['tracks'];
    }

    public static function getAlbumsByArtistId(string $id): array
    {
        /**
         * @var \App\Providers\Integrators\Apis\Spotify $spotify
         */
        $spotify = App::get('Spotify');

        return $spotify->getRelationForId(
            entityId: $id,
            entityModule: SpotifyModulesEnum::ARTISTS,
            relationModule: SpotifyModulesEnum::ALBUMS
        )['items'];
    }

    public static function getAlbumById(string $id): array
    {
        /**
         * @var \App\Providers\Integrators\Apis\Spotify $spotify
         */
        $spotify = App::get('Spotify');

        return $spotify->findById(id: $id, module: SpotifyModulesEnum::ALBUMS);
    }

    public static function getAlbumByName(string $name): array
    {
        /**
         * @var \App\Providers\Integrators\Apis\Spotify $spotify
         */
        $spotify = App::get('Spotify');

        return $spotify->indexType(
            type: SpotifyModelTypeEnum::ALBUM,
            limit: 10,
            query: $name
        );
    }

    public static function getAlbums(string $query, int $limit = 10): array
    {
        /**
         * @var \App\Providers\Integrators\Apis\Spotify $spotify
         */
        $spotify = App::get('Spotify');

        return $spotify->indexType(
            type: SpotifyModelTypeEnum::ALBUM,
            limit: $limit,
            query: $query
        );
    }

    public static function getAlbumTracks(string $id): array
    {
        /**
         * @var \App\Providers\Integrators\Apis\Spotify $spotify
         */
        $spotify = App::get('Spotify');

        return $spotify->getRelationForId(
            entityId: $id,
            entityModule: SpotifyModulesEnum::ALBUMS,
            relationModule: SpotifyModulesEnum::TRACKS
        )['items'];
    }

    public static function getPlaylistById(string $id): array
    {
        /**
         * @var \App\Providers\Integrators\Apis\Spotify $spotify
         */
        $spotify = App::get('Spotify');

        return $spotify->findById(id: $id, module: SpotifyModulesEnum::PLAYLISTS);
    }

    public static function getPlaylistByName(string $name): array
    {
        /**
         * @var \App\Providers\Integrators\Apis\Spotify $spotify
         */
        $spotify = App::get('Spotify');

        return $spotify->indexType(
            type: SpotifyModelTypeEnum::PLAYLIST,
            limit: 10,
            query: $name
        );
    }
}
