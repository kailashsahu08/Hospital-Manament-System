<?php

namespace App\Filament\Pages;

use Filament\Pages\Auth\EditProfile;

class AuthProfile extends EditProfile
{

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $navigationLabel = 'Profile';
    protected static ?string $title = 'My Profile';
    protected static ?int $navigationSort = 1;

}
