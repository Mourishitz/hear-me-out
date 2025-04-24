<?php

namespace App\Enums;

enum SpotifyModelTypeEnum: string
{
    use BaseEnum;

    case ALBUM = 'album';
    case ARTIST = 'artist';
    case TRACK = 'track';
    case PLAYLIST = 'playlist';

}
