<?php

namespace App\Filament\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class CalendarWidget extends FullCalendarWidget
{
    protected static ?int $sort = 2;
    
    protected int | string | array $columnSpan = 'full';

    public function fetchEvents(array $fetchInfo): array
    {
        return [
            [
                'title' => 'Event 1',
                'start' => '2025-05-10',
                'end' => '2025-05-11',
            ],
        ];
    }
}
