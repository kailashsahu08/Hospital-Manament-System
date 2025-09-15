<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DoctorResource\Pages;
use App\Filament\Resources\DoctorResource\RelationManagers;
use App\Models\Doctor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\{Checkbox, TextInput, Select, DatePicker, Fieldset, FileUpload, Repeater, Textarea, TimePicker};
use Filament\Tables\Columns\{TextColumn, ImageColumn};

class DoctorResource extends Resource
{
    protected static ?string $model = Doctor::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([

            TextInput::make('first_name')->required(),
            TextInput::make('last_name')->required(),
            TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(255),
            TextInput::make('phone')->tel(),
            TextInput::make('address'),
            TextInput::make('city'),
            TextInput::make('state'),
            TextInput::make('zip_code'),
            Checkbox::make('is_verified')->label('Is Verified')->default(false),
            DatePicker::make('date_of_birth'),
            Select::make('gender')
                ->options([
                    'male' => 'Male',
                    'female' => 'Female',
                    'other' => 'Other',
                ])
                ->required(),

            TextInput::make('specialization')->required(),

            Select::make('department_id')
                ->relationship('department', 'name')
                ->required(),

            TextInput::make('license_number'),
            TextInput::make('experience_years')->numeric()->minValue(0),
            TextInput::make('consultation_fee')->numeric()->prefix('$'),
            Forms\Components\Repeater::make('availability_schedule')
                ->schema([
                    Forms\Components\Grid::make(1) // each day in its own block
                        ->schema([
                            Fieldset::make(fn($state) => $state['day_name'] ?? 'Day')
                                ->schema([
                                    TextInput::make('day_name')
                                        ->disabled()
                                        ->dehydrated()
                                        ->hidden(), // keep hidden, title already shown in Fieldset

                                    Checkbox::make('isAvailable')
                                        ->label('Available')
                                        ->inline(false),

                                    Repeater::make('time_intervals')
                                        ->schema([
                                            TimePicker::make('start_time')->required(),
                                            TimePicker::make('end_time')->required(),
                                            TextInput::make('max_patients')
                                                ->numeric()
                                                ->minValue(1)
                                                ->default(10),
                                        ])
                                        ->columns(3)
                                        ->minItems(0)
                                        ->label('Time Slots'),
                                ])
                                ->columns(1)
                                ->columnSpanFull()
                                ->extraAttributes([
                                    'class' => 'bg-gray-50 rounded-lg p-4 shadow-sm border border-gray-200'
                                ]),
                        ]),
                ])
                ->default(function () {
                    return collect([
                        'Monday',
                        'Tuesday',
                        'Wednesday',
                        'Thursday',
                        'Friday',
                        'Saturday',
                        'Sunday',
                    ])->map(fn($day) => [
                        'day_name' => $day,
                        'isAvailable' => false,
                        'time_intervals' => [],
                    ])->toArray();
                })
                ->columns(3)
                ->grid()
                ->deletable(false)
                ->addable(false)
                ->label('Availability Schedule')
                ->columnSpanFull(),

            FileUpload::make('profile_picture')
                ->image()
                ->directory('doctor-profile-pictures'),

            Textarea::make('bio')->rows(4),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            ImageColumn::make('profile_picture')->getStateUsing(function ($record) {
                return $record->profile_picture ?: 'https://img.freepik.com/free-psd/3d-illustration-person-with-sunglasses_23-2149436188.jpg';
            })->circular(),
            TextColumn::make('name')->searchable()->sortable(),
            TextColumn::make('user.email')->label('Email')->searchable(),
            TextColumn::make('specialization')->searchable(),
            TextColumn::make('department.name')->label('Department'),
            TextColumn::make('phone'),
            TextColumn::make('experience_years')->label('Experience (years)'),
            TextColumn::make('consultation_fee')->money('usd'),
        ])
            ->filters([
                Tables\Filters\SelectFilter::make('department')
                    ->relationship('department', 'name'),

                Tables\Filters\SelectFilter::make('gender')
                    ->options([
                        'male' => 'Male',
                        'female' => 'Female',
                        'other' => 'Other',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // You can add AppointmentResource::class here if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDoctors::route('/'),
            'create' => Pages\CreateDoctor::route('/create'),
            'edit' => Pages\EditDoctor::route('/{record}/edit'),
            'view' => Pages\ViewDoctor::route('/{record}'),
        ];
    }
}
