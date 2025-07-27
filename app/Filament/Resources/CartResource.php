<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CartResource\Pages;
use App\Models\Cart;
use App\Models\ProductVariant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CartResource extends Resource
{
    protected static ?string $model = Cart::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationLabel = 'Carts';
    protected static ?string $navigationGroup = 'Orders & Sales';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'email')
                    ->required()
                    ->searchable()
                    ->label('User'),

                Forms\Components\Select::make('product_id')
                    ->relationship('product', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->label('Product')
                    ->reactive(),

                Forms\Components\Select::make('product_variant_id')
                    ->label('Variant')
                    ->required()
                    ->options(function (callable $get) {
                        $productId = $get('product_id');

                        if (!$productId) {
                            return [];
                        }

                        return ProductVariant::where('product_id', $productId)
                            ->get()
                            ->mapWithKeys(function ($variant) {
                                // Customize the label for clarity (optional)
                                return [
                                    $variant->id => "{$variant->sku} ({$variant->size?->label} / {$variant->color?->name})",
                                ];
                            });
                    })
                    ->disabled(fn(callable $get) => !$get('product_id'))
                    ->reactive()
                    ->afterStateHydrated(function ($component, $state) {
                        // Ensures variant is hydrated on edit
                        $component->state($state);
                    })
                    ->preload(),

                Forms\Components\TextInput::make('quantity')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->label('Quantity'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.full_name')->label('User')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('product.name')->label('Product')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('variant.sku')->label('Variant SKU')->sortable(),
                Tables\Columns\TextColumn::make('quantity')->label('Qty')->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->label('Total')
                    ->money('KES')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Added')
                    ->dateTime('d M Y H:i'),
            ])
            ->filters([
                // You can add filters here later
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCarts::route('/'),
            'create' => Pages\CreateCart::route('/create'),
            'edit' => Pages\EditCart::route('/{record}/edit'),
        ];
    }
}
