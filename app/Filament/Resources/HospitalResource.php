<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HospitalResource\Pages;
use App\Filament\Resources\HospitalResource\RelationManagers;
use App\Models\Hospital;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HospitalResource extends Resource
{
    protected static ?string $model = Hospital::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationGroup = 'Management';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Hospital Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')->required()->maxLength(255),
                        Forms\Components\TextInput::make('code')->unique(ignoreRecord: true)->required(),
                        Forms\Components\TextInput::make('email')->email(),
                        Forms\Components\TextInput::make('phone'),
                        Forms\Components\Textarea::make('address')->rows(2),
                        Forms\Components\TextInput::make('city'),
                        Forms\Components\TextInput::make('state'),
                        Forms\Components\TextInput::make('zip_code'),
                        Forms\Components\TextInput::make('country'),
                        Forms\Components\TextInput::make('website'),
                        Forms\Components\TextInput::make('license_number'),
                        Forms\Components\Select::make('type')
                            ->options([
                                'general' => 'General',
                                'specialty' => 'Specialty',
                                'clinic' => 'Clinic',
                                'other' => 'Other',
                            ]),
                    ])->columns(2),

                Forms\Components\Section::make('Beds & Facilities')
                    ->schema([
                        Forms\Components\TextInput::make('total_beds')->numeric(),
                        Forms\Components\TextInput::make('available_beds')->numeric(),
                        Forms\Components\Textarea::make('facilities')->rows(3),
                        Forms\Components\FileUpload::make('logo')->image()->directory('hospitals/logos'),
                    ])->columns(2),

                Forms\Components\Section::make('Location & Timings')
                    ->schema([
                        Forms\Components\TextInput::make('latitude'),
                        Forms\Components\TextInput::make('longitude'),
                        Forms\Components\TimePicker::make('opening_time'),
                        Forms\Components\TimePicker::make('closing_time'),
                        Forms\Components\Toggle::make('is_24_hours')->label('Open 24 Hours'),
                        Forms\Components\Toggle::make('is_active')->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo')->circular(),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('code')->sortable(),
                Tables\Columns\TextColumn::make('city'),
                Tables\Columns\TextColumn::make('state'),
                Tables\Columns\TextColumn::make('total_beds'),
                Tables\Columns\TextColumn::make('available_beds')->badge(),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
                Tables\Columns\IconColumn::make('is_24_hours')->boolean(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            // e.g., RelationManagers for doctors, departments, etc.
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHospitals::route('/'),
            'create' => Pages\CreateHospital::route('/create'),
            'edit' => Pages\EditHospital::route('/{record}/edit'),
            // 'view' => Pages\ViewHospital::route('/{record}'),
        ];
    }
}
