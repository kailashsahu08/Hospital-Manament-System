<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PatientResource\Pages;
use App\Filament\Resources\PatientResource\RelationManagers;
use App\Models\Patient;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\{TextInput, Select, DatePicker, FileUpload, Textarea};
use Filament\Tables\Columns\{TextColumn, ImageColumn};

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('user_id')
                ->relationship('user', 'name')
                ->required(),

            TextInput::make('first_name')->required(),
            TextInput::make('last_name')->required(),
            TextInput::make('phone')->tel(),
            TextInput::make('address'),
            TextInput::make('city'),
            TextInput::make('state'),
            TextInput::make('zip_code'),
            DatePicker::make('date_of_birth'),
            Select::make('gender')
                ->options([
                    'male' => 'Male',
                    'female' => 'Female',
                    'other' => 'Other',
                ])
                ->required(),

            Select::make('blood_group')
                ->options([
                    'A+' => 'A+',
                    'A-' => 'A-',
                    'B+' => 'B+',
                    'B-' => 'B-',
                    'O+' => 'O+',
                    'O-' => 'O-',
                    'AB+' => 'AB+',
                    'AB-' => 'AB-',
                ]),

            TextInput::make('allergies'),
            TextInput::make('chronic_diseases'),

            TextInput::make('emergency_contact_name'),
            TextInput::make('emergency_contact_relationship'),
            TextInput::make('emergency_contact_phone')->tel(),

            TextInput::make('insurance_provider'),
            TextInput::make('insurance_policy_number'),

            TextInput::make('height')->suffix('cm')->numeric(),
            TextInput::make('weight')->suffix('kg')->numeric(),

            FileUpload::make('profile_picture')
                ->image()
                ->directory('patient-profile-pictures'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            ImageColumn::make('profile_picture')->circular(),
            TextColumn::make('first_name')->searchable()->sortable(),
            TextColumn::make('last_name')->searchable()->sortable(),
            TextColumn::make('phone'),
            TextColumn::make('blood_group'),
            TextColumn::make('gender'),
            TextColumn::make('city'),
        ])
            ->filters([
                Tables\Filters\SelectFilter::make('gender')->options([
                    'male' => 'Male',
                    'female' => 'Female',
                    'other' => 'Other',
                ]),
                Tables\Filters\SelectFilter::make('blood_group')->options([
                    'A+' => 'A+',
                    'A-' => 'A-',
                    'B+' => 'B+',
                    'B-' => 'B-',
                    'O+' => 'O+',
                    'O-' => 'O-',
                    'AB+' => 'AB+',
                    'AB-' => 'AB-',
                ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPatients::route('/'),
            'create' => Pages\CreatePatient::route('/create'),
            'edit' => Pages\EditPatient::route('/{record}/edit'),
        ];
    }
}
