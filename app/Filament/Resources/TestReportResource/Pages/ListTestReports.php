<?php

namespace App\Filament\Resources\TestReportResource\Pages;

use App\Filament\Resources\TestReportResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTestReports extends ListRecords
{
    protected static string $resource = TestReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
