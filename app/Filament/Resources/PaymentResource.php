<?php

namespace App\Filament\Resources;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Payment;
use App\Models\Order;
use App\Filament\Resources\PaymentResource\Pages;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationLabel = 'Payments';
    protected static ?string $navigationGroup = 'Sales Management';
    protected static ?int $navigationSort = 3;
    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('order_id')
                ->label('Order')
                ->relationship('order', 'id')
                ->required()
                ->searchable()
                ->preload()
                ->live()
                ->afterStateUpdated(function ($state, callable $set) {
                    $order = \App\Models\Order::find($state);
                    if ($order) {
                        $set('amount', $order->total);
                    }
                }),

            Forms\Components\Select::make('payment_method')
                ->label('Payment Method')
                ->options(\App\Enums\PaymentMethod::class)
                ->required(),

            Forms\Components\TextInput::make('transaction_id')
                ->label('Transaction ID')
                ->required(),

            Forms\Components\TextInput::make('amount')
                ->label('Amount')
                ->numeric()
                ->disabled() // prevent manual editing (optional)
                ->dehydrated() // still submit the value
                ->prefix('KES')
                ->required(),

            Forms\Components\Select::make('status')
                ->label('Payment Status')
                ->options(\App\Enums\PaymentStatus::class)
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order.id')
                    ->label('Order ID')
                    ->searchable()
                    ->copyable()
                    ->color('primary'),

                TextColumn::make('payment_method')
                    ->label('Method')
                    ->badge()
                    ->color(fn(PaymentMethod $state) => match ($state) {
                        PaymentMethod::Mpesa => 'success',
                        PaymentMethod::Card => 'primary',
                        PaymentMethod::PayPal => 'info',
                        PaymentMethod::BankTransfer => 'warning',
                        PaymentMethod::Cash => 'gray',
                    })
                    ->formatStateUsing(
                        fn(PaymentMethod $state) =>
                        ucfirst(str_replace('_', ' ', $state->value))
                    ),

                TextColumn::make('transaction_id')
                    ->label('Transaction ID')
                    ->copyable()
                    ->tooltip('Click to copy'),

                TextColumn::make('amount')
                    ->label('Amount')
                    ->money('KES')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(PaymentStatus $state): string => match ($state) {
                        PaymentStatus::Pending => 'warning',
                        PaymentStatus::Completed => 'success',
                        PaymentStatus::Failed => 'danger',
                    })
                    ->formatStateUsing(fn(PaymentStatus $state): string => ucfirst($state->value))
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Paid On')
                    ->dateTime('M d, Y H:i')
                    ->sortable(),
            ])
            ->filters([
                // Can use Payment::scopeCompleted(), etc., if needed
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
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
