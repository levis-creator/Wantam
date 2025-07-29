<?php

namespace App\Filament\Resources;

use App\Models\Shipping;
use App\Enums\ShippingStatus;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Resources\ShippingResource\Pages;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;

class ShippingResource extends Resource
{
    protected static ?string $model = Shipping::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationLabel = 'Shippings';
    protected static ?string $navigationGroup = 'Sales Management';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('order_id')
                ->label('Order')
                ->relationship('order', 'id')
                ->searchable()
                ->preload()
                ->required(),

            Forms\Components\Select::make('address_id')
                ->label('Shipping Address')
                ->relationship('address', 'address')
                ->searchable()
                ->preload()
                ->required(),

            Forms\Components\TextInput::make('city')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('postal_code')
                ->label('Postal Code')
                ->required()
                ->maxLength(20),

            Forms\Components\TextInput::make('country')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('tracking_number')
                ->label('Tracking Number')
                ->nullable()
                ->maxLength(255),

            Forms\Components\Select::make('status')
                ->options(ShippingStatus::options())
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
                    ->sortable(),

                TextColumn::make('address.full_address')
                    ->label('Address')
                    ->wrap()
                    ->searchable(),

                TextColumn::make('city')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('postal_code')
                    ->label('Postal Code')
                    ->sortable(),

                TextColumn::make('country')
                    ->sortable(),

                TextColumn::make('tracking_number')
                    ->label('Tracking #')
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn(ShippingStatus $state): string => match ($state) {
                        ShippingStatus::Pending => 'gray',
                        ShippingStatus::Shipped => 'info',
                        ShippingStatus::Delivered => 'success',
                        ShippingStatus::Cancelled => 'danger',
                        default => 'secondary'
                    })
                    ->formatStateUsing(fn(ShippingStatus $state) => ucfirst($state->value)),

                TextColumn::make('created_at')
                    ->label('Shipped On')
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListShippings::route('/'),
            'create' => Pages\CreateShipping::route('/create'),
            'edit' => Pages\EditShipping::route('/{record}/edit'),
        ];
    }
}
