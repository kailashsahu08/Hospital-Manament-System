<?php
namespace App\Filament\Pages;

use DiogoGPinto\AuthUIEnhancer\Pages\Auth\Concerns\HasCustomLayout;
use Filament\Actions\Action as ActionsAction;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Set;
use Filament\Pages\Auth\Login as BasePage;

class AuthLogin extends BasePage
{
    use HasCustomLayout;

    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getRememberFormComponent(),
                        Actions::make([
                            Action::make('admin')
                                ->label('Admin')
                                ->icon('heroicon-m-user-circle')
                                ->action(function (Set $set) {
                                    $set('email','admin@example.com');
                                    $set('password','password');
                                })
                                ->size('sm')
                                ->color('gray'),

                            Action::make('doctor')
                                ->label('Doctor')
                                ->icon('heroicon-m-user-group')
                                ->action(function (Set $set) {
                                    $set('email','doctor@example.com');
                                    $set('password','doctor@example.com');
                                })
                                ->size('sm')
                                ->color('gray'),

                            Action::make('patient')
                                ->label('Patient')
                                ->icon('heroicon-m-user')
                                ->action(function (Set $set) {
                                    $set('email','patient@example.com');
                                    $set('password','patient@example.com');
                                })
                                ->size('sm')
                                ->color('gray'),
                        ])
                        ->alignment('center')
                        ->fullWidth()
                        ->columns(3)
                        ->columnSpanFull(),
                        Actions::make([
                            Action::make('redirect_to_external')
                                ->label('Go to Dashboard')
                                ->color('success')
                                ->url('http://localhost:5173/')
                        ])
                        ->alignment('center')
                        ->fullWidth(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }
}