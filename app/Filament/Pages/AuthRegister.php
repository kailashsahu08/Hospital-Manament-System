<?php

namespace App\Filament\Pages;

use App\Models\Department;
use App\Models\Doctor;
use App\Models\Patient;
use DiogoGPinto\AuthUIEnhancer\Pages\Auth\Concerns\HasCustomLayout;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Pages\Auth\Register as BasePage;
use Illuminate\Database\Eloquent\Model;

class AuthRegister extends BasePage
{
    use HasCustomLayout;
    // protected static string $view = 'filament.pages.auth-register';
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                        Checkbox::make('is_doctor')
                            ->label('Are you an doctor?')
                            ->default(false),
                    ])
                    ->statePath('data'),
            ),
        ];
    }
    protected function handleRegistration(array $data): Model
    {
        $isDoctor = $data['is_doctor'] ?? false;
        unset($data['is_doctor']);

        if ($isDoctor) {
            $doctor = Doctor::create($data);
            $doctor->user->assignRole('doctor');
            return $doctor->user; // return user model
        } else {
            $patient = Patient::create($data);
            $patient->user->assignRole('patient');
            return $patient->user; // return user model
        }
    }
}
