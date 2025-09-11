<?php

namespace App\Providers\Filament;

use Althinect\FilamentSpatieRolesPermissions\FilamentSpatieRolesPermissionsPlugin;
use App\Filament\Pages\AuthLogin;
use App\Filament\Pages\AuthProfile;
use App\Filament\Pages\AuthRegister;
use App\Filament\Widgets\CalendarWidget;
use App\Filament\Widgets\StatsOverview;
use DiogoGPinto\AuthUIEnhancer\AuthUIEnhancerPlugin;
use Filament\Enums\ThemeMode;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Hasnayeen\Themes\Http\Middleware\SetTheme;
use Hasnayeen\Themes\ThemesPlugin;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->defaultThemeMode(ThemeMode::Dark)
            ->id('admin')
            ->path('admin')
            ->login(AuthLogin::class)
            ->registration(AuthRegister::class)
            ->profile(AuthProfile::class)
            ->colors([
                'primary' => Color::Green,
                'secondary' => Color::Gray,
                'success' => Color::Green,
                'danger' => Color::Red,
                'warning' => Color::Yellow,
                'info' => Color::Blue,
            ])
            ->theme(asset('css/filament/admin/theme.css'))
            ->darkMode(true)
            ->brandLogo(asset('images/logo.svg'))
            ->brandLogoHeight('4rem')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                StatsOverview::class,
                CalendarWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                SetTheme::class
            ])
            ->plugins([
                FilamentSpatieRolesPermissionsPlugin::make(),
                ThemesPlugin::make()
                    ->canViewThemesPage(fn () => optional(auth()->user())->hasRole('admin') ?? false),

                AuthUIEnhancerPlugin::make()
                    ->formPanelPosition('right')
                    ->formPanelWidth('40%')
                    ->emptyPanelBackgroundImageUrl('https://images.pexels.com/photos/356040/pexels-photo-356040.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1'),

                FilamentFullCalendarPlugin::make()
                    ->selectable(true)
                    ->editable(true)
                    ->timezone('UTC')
                    ->locale('en')
                    ->plugins([
                        'interaction',
                        'dayGrid',
                        'timeGrid',
                        'list'
                    ])
                    ->config([
                        'headerToolbar' => [
                            'left' => 'prev,next today',
                            'center' => 'title',
                            'right' => 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                        ],
                    ])
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
