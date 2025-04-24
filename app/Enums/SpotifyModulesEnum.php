<?php

namespace App\Enums;

enum SpotifyModulesEnum: string
{
    use BaseEnum;

    case ALBUMS = 'albums';
    case ARTISTS = 'artists';
    case TRACKS = 'tracks';
    case TOP_TRACKS = 'top-tracks';
    case PLAYLISTS = 'playlists';

}
