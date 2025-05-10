<?php

namespace App\Filament\Widgets;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Doctors', Doctor::count())
                ->description('Active medical professionals')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success'),

            Stat::make('Total Patients', Patient::count())
                ->description('Registered patients')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Total Appointments', Appointment::count())
                ->description('Scheduled consultations')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('warning'),
        ];
    }
} 