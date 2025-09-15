<?php

namespace App\Filament\Resources\DoctorResource\Pages;

use App\Filament\Resources\DoctorResource;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\{Section, Grid, TextEntry, ImageEntry, RepeatableEntry};
use Filament\Resources\Pages\ViewRecord;

class ViewDoctor extends ViewRecord
{
    protected static string $resource = DoctorResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Doctor Profile')
                    ->schema([
                        ImageEntry::make('profile_picture')
                            ->label('')
                            ->circular()
                            ->getStateUsing(fn ($record) =>
                                $record->profile_picture
                                    ? asset('storage/' . $record->profile_picture)
                                    : 'https://img.freepik.com/free-psd/3d-illustration-person-with-sunglasses_23-2149436188.jpg'
                            )
                            ->columnSpanFull()
                            ->extraAttributes(['class' => ' w-32 h-32 mb-4']),
                        
                        TextEntry::make('name')
                            ->label('Full Name')
                            ->size('xl')
                            ->weight('bold')
                            ->columnSpanFull(),

                        TextEntry::make('email')->icon('heroicon-o-envelope'),
                        TextEntry::make('phone')->icon('heroicon-o-phone'),
                        TextEntry::make('specialization')->badge(),
                        TextEntry::make('department.name')->label('Department')->badge('success'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make('Professional Details')
                    ->schema([
                        Grid::make(2)->schema([
                            TextEntry::make('gender')->badge(),
                            TextEntry::make('date_of_birth')->date(),
                            TextEntry::make('license_number'),
                            TextEntry::make('experience_years')->label('Experience (Years)'),
                            TextEntry::make('consultation_fee')->money('usd'),
                            TextEntry::make('is_verified'),
                        ]),
                        TextEntry::make('bio')->columnSpanFull(),
                    ])
                    ->collapsible(),

                Section::make('Availability Schedule')
                    ->schema([
                        RepeatableEntry::make('availability_schedule')
                            ->schema([
                                TextEntry::make('day_name')
                                    ->weight('bold')
                                    ->badge(),

                                TextEntry::make('isAvailable'),

                                RepeatableEntry::make('time_intervals')
                                    ->schema([
                                        TextEntry::make('start_time'),
                                        TextEntry::make('end_time'),
                                        TextEntry::make('max_patients')
                                            ->label('Max Patients'),
                                    ])
                                    ->columns(3)
                                    ->hidden(fn ($state, $record) => !$state || empty($state)),
                            ])
                            ->columnSpan(2),
                    ])
                    ->collapsible(),
            ]);
    }
}
