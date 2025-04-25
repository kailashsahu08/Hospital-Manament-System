<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestReportResource\Pages;
use App\Filament\Resources\TestReportResource\RelationManagers;
use App\Models\TestReport;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TestReportResource extends Resource
{
    protected static ?string $model = TestReport::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Medical Records';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('patient_id')
                    ->relationship('patient', 'name')
                    ->required(),

                Forms\Components\Select::make('doctor_id')
                    ->relationship('doctor', 'name')
                    ->required(),

                Forms\Components\TextInput::make('test_name')
                    ->required(),

                Forms\Components\DatePicker::make('test_date')
                    ->required(),

                Forms\Components\Textarea::make('test_result')
                    ->rows(3)
                    ->required(),

                Forms\Components\Textarea::make('result_interpretation')
                    ->rows(2),

                Forms\Components\TextInput::make('normal_range')
                    ->nullable(),

                Forms\Components\TextInput::make('performed_by')
                    ->nullable(),

                Forms\Components\FileUpload::make('report_file')
                    ->directory('test-reports')
                    ->downloadable()
                    ->nullable(),

                Forms\Components\Toggle::make('is_critical')
                    ->label('Is Critical?'),

                Forms\Components\Textarea::make('remarks')
                    ->rows(2)
                    ->nullable(),

                Forms\Components\Toggle::make('follow_up_required'),

                Forms\Components\DatePicker::make('follow_up_date')
                    ->visible(fn ($get) => $get('follow_up_required')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('patient.name')
                    ->label('Patient')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('doctor.name')
                    ->label('Doctor')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('test_name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('test_date')
                    ->date()
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_critical')
                    ->boolean()
                    ->label('Critical'),

                Tables\Columns\IconColumn::make('follow_up_required')
                    ->boolean()
                    ->label('Follow-Up?'),

                Tables\Columns\TextColumn::make('follow_up_date')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('performed_by')
                    ->toggleable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Created At'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTestReports::route('/'),
            'create' => Pages\CreateTestReport::route('/create'),
            'edit' => Pages\EditTestReport::route('/{record}/edit'),
        ];
    }
}
