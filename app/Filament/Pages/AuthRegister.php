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
        $model =  $this->getUserModel()::create($data);
        if ($isDoctor) {
            $model->assignRole('doctor');
            Doctor::create(['user_id' => $model->id , 'name' => $data['name']]);
        } else {
            $model->assignRole('patient');
            Patient::create(['user_id' => $model->id , 'name' => $data['name']]);
        }
        return $model;
    }
}
