<?php

namespace App\Providers\Interfaces;

interface SongProviderInterface
{
    public static function getTrackById(string $id): array;

    public static function getTrackByName(string $name): array;

    public static function getArtistById(string $id): array;

    public static function getArtistByName(string $name): array;

    public static function getAlbumById(string $id): array;

    public static function getAlbumByName(string $name): array;

    public static function getPlaylistById(string $id): array;

    public static function getPlaylistByName(string $name): array;
}
