<?php

namespace App\Enums;

enum RatingCriteriaEnum: string
{
    use BaseEnum;

    case LYRICS = 'lyrics';
    case MEANING = 'meaning';
    case PRODUCTION = 'production';
    case HARMONY = 'harmony';
    case CONTEXT = 'context';
}
