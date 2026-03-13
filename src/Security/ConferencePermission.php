<?php

declare(strict_types=1);

namespace App\Security;

enum ConferencePermission
{
    public const EDIT = 'conference/edit';

    public static function belong(string $permission): bool
    {
        return str_starts_with($permission, 'conference/');
    }
}
