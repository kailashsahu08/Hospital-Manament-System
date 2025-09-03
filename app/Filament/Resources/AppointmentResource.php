<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentResource\Pages;
use App\Filament\Resources\AppointmentResource\RelationManagers;
use App\Models\Appointment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\{
    Select,
    DatePicker,
    TimePicker,
    Toggle,
    Textarea,
    TextInput
};
use Filament\Tables\Columns\{
    TextColumn,
    BadgeColumn,
    BooleanColumn
};

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('doctor_id')
                ->relationship('doctor', 'first_name')
                ->required(),

            Select::make('patient_id')
                ->relationship('patient', 'first_name')
                ->required(),

            Select::make('department_id')
                ->relationship('department', 'name')
                ->required(),

            DatePicker::make('appointment_date')
                ->required(),

            TimePicker::make('start_time')
                ->required(),

            TimePicker::make('end_time')
                ->required(),

            Select::make('status')
                ->options([
                    'Scheduled' => 'Scheduled',
                    'Completed' => 'Completed',
                    'Cancelled' => 'Cancelled',
                    'No-show' => 'No-show',
                ])
                ->required(),

            Select::make('type')
                ->options([
                    'In-person' => 'In-person',
                    'Virtual' => 'Virtual',
                ])
                ->required(),
            Select::make('previous_appointment_id')
                ->label('Previous Appointment')
                ->relationship('previousAppointment', 'id'),

            Textarea::make('reason')
                ->maxLength(500),

            Textarea::make('notes')
                ->maxLength(1000),

            Toggle::make('is_follow_up')
                ->label('Is Follow-up'),

            Select::make('previous_appointment_id')
                ->label('Previous Appointment')
                ->relationship('previousAppointment', 'id')
                ->searchable()
                ->hiddenOn('create'), // optional if you only want to allow after the first one
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('doctor.first_name')
                    ->label('Doctor')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('patient.first_name')
                    ->label('Patient')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('department.name')
                    ->label('Department'),

                TextColumn::make('appointment_date')
                    ->date()
                    ->sortable(),

                TextColumn::make('start_time')->label('Start'),
                TextColumn::make('end_time')->label('End'),

                BadgeColumn::make('status')
                    ->colors([
                        'primary' => 'Scheduled',
                        'success' => 'Completed',
                        'danger' => 'Cancelled',
                        'warning' => 'No-show',
                    ]),

                TextColumn::make('type')->sortable(),

                BooleanColumn::make('is_follow_up')->label('Follow-up'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'Scheduled' => 'Scheduled',
                        'Completed' => 'Completed',
                        'Cancelled' => 'Cancelled',
                        'No-show' => 'No-show',
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}
