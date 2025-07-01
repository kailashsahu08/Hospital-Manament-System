<?php

namespace App\Filament\Resources;

use Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource as Roles;

class RoleResource extends Roles 
{
    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->can('view-any Roles') || auth()->user()?->can('view Role') ?? false;
    }
}
