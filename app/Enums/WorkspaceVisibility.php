<?php

namespace App\Enums;

use App\Enums\Concerns\HasConfigLabels;

/** workspaces.visibility */
enum WorkspaceVisibility: string
{
    use HasConfigLabels;

    case Private = 'private';
    case Public = 'public';

    public static function configGroup(): string
    {
        return 'workspace_visibility';
    }

    public static function default(): self
    {
        return self::Private;
    }
}
