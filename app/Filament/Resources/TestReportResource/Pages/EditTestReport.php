<?php

namespace App\Filament\Resources\TestReportResource\Pages;

use App\Filament\Resources\TestReportResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTestReport extends EditRecord
{
    protected static string $resource = TestReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
