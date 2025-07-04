<?php

namespace App\Filament\Resources;

use Althinect\FilamentSpatieRolesPermissions\Resources\PermissionResource as ResourcesPermissionResource;

class PermissionResource extends ResourcesPermissionResource
{
    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->can('view-any Permissions') 
            || auth()->user()?->can('view Permission') 
            ?? false;
    }
}
