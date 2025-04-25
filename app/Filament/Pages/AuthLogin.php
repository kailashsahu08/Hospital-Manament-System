<?php

namespace App\Filament\Pages;

use DiogoGPinto\AuthUIEnhancer\Pages\Auth\Concerns\HasCustomLayout;
use Filament\Forms\Form;
use Filament\Pages\Auth\Login as BasePage;

class AuthLogin extends BasePage
{
    use HasCustomLayout;
    // protected static string $view = 'filament.pages.auth-login';
}
