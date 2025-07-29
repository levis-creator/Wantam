<?php

namespace App\Filament\Resources;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers\OrderItemRelationManager;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationLabel = 'Orders';
    protected static ?string $navigationGroup = 'Sales Management';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('user_id')
                ->label('Customer')
                ->relationship('user', 'email')
                ->searchable()
                ->preload()
                ->required(),

            Forms\Components\Select::make('status')
                ->label('Order Status')
                ->options(OrderStatus::options())
                ->required(),

            Forms\Components\Select::make('payment_method')
                ->label('Payment Method')
                ->options(
                    PaymentMethod::options()
                )
                ->required(),

            Forms\Components\Select::make('address_id')
                ->label('Shipping Address')
                ->relationship('address', 'address')
                ->searchable()
                ->preload()
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.email')
                    ->label('Customer Email')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(OrderStatus $state): string => match ($state) {
                        OrderStatus::Pending => 'gray',
                        OrderStatus::Paid => 'primary',
                        OrderStatus::Shipped => 'info',
                        OrderStatus::Processing => 'warning',
                        OrderStatus::Completed => 'success',
                        OrderStatus::Cancelled => 'danger',
                    })
                    ->formatStateUsing(fn(OrderStatus $state) => ucfirst($state->value))
                    ->sortable(),

                TextColumn::make('total')
                    ->label('Total (KES)')
                    ->money('KES')
                    ->sortable(),

                TextColumn::make('payment_method')
                    ->label('Payment Method')
                    ->badge()
                    ->color(fn(PaymentMethod $state): string => match ($state) {
                        PaymentMethod::Mpesa => 'success',
                        PaymentMethod::Card => 'primary',
                        PaymentMethod::PayPal => 'info',
                        PaymentMethod::BankTransfer => 'warning',
                        PaymentMethod::CashOnDelivery => 'danger',
                        PaymentMethod::Cash => 'gray',
                    })
                    ->formatStateUsing(
                        fn(PaymentMethod $state): string =>
                        ucfirst(str_replace('_', ' ', $state->value))
                    )
                    ->sortable(),

                TextColumn::make('address.full_address')
                    ->label('Shipping Address')
                    ->wrap()
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Order Date')
                    ->dateTime('M d, Y H:i')
                    ->sortable(),
            ])
            ->filters([])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            OrderItemRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
            'view' => Pages\ViewOrder::route('/{record}'),
        ];
    }
}
