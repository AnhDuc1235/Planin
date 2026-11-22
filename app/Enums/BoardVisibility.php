<?php

namespace App\Enums;

use App\Enums\Concerns\HasConfigLabels;

/** boards.visibility */
enum BoardVisibility: string
{
    use HasConfigLabels;

    case Private = 'private';
    case Workspace = 'workspace';
    case Public = 'public';

    public static function configGroup(): string
    {
        return 'board_visibility';
    }

    public static function default(): self
    {
        return self::Workspace;
    }
}
