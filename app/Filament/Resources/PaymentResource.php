<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Filament\Resources\PaymentResource\RelationManagers;
use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationGroup = 'Billing';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('appointment_id')
                    ->relationship('appointment', 'id')
                    ->required(),

                Forms\Components\Select::make('patient_id')
                    ->relationship('patient', 'name')
                    ->required(),

                Forms\Components\TextInput::make('amount')
                    ->numeric()
                    ->required(),

                Forms\Components\DatePicker::make('payment_date')
                    ->required(),

                Forms\Components\Select::make('payment_method')
                    ->options([
                        'Credit Card' => 'Credit Card',
                        'Cash' => 'Cash',
                        'Insurance' => 'Insurance',
                        'Bank Transfer' => 'Bank Transfer',
                        'Other' => 'Other',
                    ])
                    ->required(),

                Forms\Components\TextInput::make('transaction_id')
                    ->nullable(),

                Forms\Components\Select::make('status')
                    ->options([
                        'Pending' => 'Pending',
                        'Completed' => 'Completed',
                        'Failed' => 'Failed',
                        'Refunded' => 'Refunded',
                    ])
                    ->required(),

                Forms\Components\TextInput::make('invoice_number')
                    ->nullable(),

                Forms\Components\TextInput::make('discount')
                    ->numeric()
                    ->nullable(),

                Forms\Components\TextInput::make('tax')
                    ->numeric()
                    ->nullable(),

                Forms\Components\TextInput::make('total_amount')
                    ->numeric()
                    ->required(),

                Forms\Components\Toggle::make('is_insured'),

                Forms\Components\TextInput::make('insurance_coverage_amount')
                    ->numeric()
                    ->nullable(),

                Forms\Components\TextInput::make('patient_responsibility')
                    ->numeric()
                    ->nullable(),

                Forms\Components\Textarea::make('notes')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('appointment.id')
                    ->label('Appointment ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('patient.name')
                    ->label('Patient')
                    ->searchable(),

                Tables\Columns\TextColumn::make('amount')
                    ->money('usd')
                    ->sortable(),

                Tables\Columns\TextColumn::make('payment_date')
                    ->date(),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'secondary' => 'Pending',
                        'success' => 'Completed',
                        'danger' => 'Failed',
                        'warning' => 'Refunded',
                    ])
                    ->sortable(),

                Tables\Columns\TextColumn::make('payment_method'),

                Tables\Columns\IconColumn::make('is_insured')
                    ->boolean(),

                Tables\Columns\TextColumn::make('total_amount')
                    ->money('usd')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable(),
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
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}
