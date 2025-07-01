<?php

namespace App\Filament\Pages;

use Filament\Pages\Auth\EditProfile;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Auth;

class AuthProfile extends EditProfile
{
    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $navigationLabel = 'My Profile';
    protected static ?int $navigationSort = 1;

    public function form(Form $form): Form
    {
        $user = Auth::user();
        $isDoctor = $user->type === 'doctor';
        $isPatient = $user->type === 'patient';

        return $form
            ->schema([
                $this->getNameFormComponent(),
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
                
                // Common fields for all users
                TextInput::make('phone')
                    ->label('Phone Number')
                    ->tel()
                    ->maxLength(15),
                    
                DatePicker::make('date_of_birth')
                    ->label('Date of Birth')
                    ->maxDate(now()),
                    
                Textarea::make('address')
                    ->label('Address')
                    ->rows(3)
                    ->maxLength(255),

                // Doctor specific fields
                ...($isDoctor ? [
                    TextInput::make('specialization')
                        ->label('Specialization')
                        ->maxLength(100),
                        
                    TextInput::make('license_number')
                        ->label('Medical License Number')
                        ->maxLength(50),
                        
                    Textarea::make('qualifications')
                        ->label('Qualifications')
                        ->rows(3)
                        ->maxLength(500),
                ] : []),

                // Patient specific fields
                ...($isPatient ? [
                    Select::make('blood_group')
                        ->label('Blood Group')
                        ->options([
                            'A+' => 'A+',
                            'A-' => 'A-',
                            'B+' => 'B+',
                            'B-' => 'B-',
                            'AB+' => 'AB+',
                            'AB-' => 'AB-',
                            'O+' => 'O+',
                            'O-' => 'O-',
                        ]),
                        
                    Textarea::make('medical_history')
                        ->label('Medical History')
                        ->rows(3)
                        ->maxLength(500),
                        
                    TextInput::make('emergency_contact')
                        ->label('Emergency Contact')
                        ->tel()
                        ->maxLength(15),
                ] : []),
            ]);
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Profile updated successfully!';
    }
}
