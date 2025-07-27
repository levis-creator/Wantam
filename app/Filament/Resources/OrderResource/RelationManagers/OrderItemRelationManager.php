<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\RelationManagers\RelationManager;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderItemRelationManager extends RelationManager
{
    protected static string $relationship = 'items';
    protected static ?string $title = 'Order Items';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('product_id')
                    ->label('Product')
                    ->relationship('product', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->live()
                    ->reactive(), // Enables dynamic reactivity

                Forms\Components\Select::make('product_variant_id')
                    ->label('Variant SKU')
                    ->required()
                    ->searchable()
                    ->reactive()
                    ->options(function (callable $get) {
                        $productId = $get('product_id');

                        if (!$productId) {
                            return [];
                        }

                        return \App\Models\ProductVariant::where('product_id', $productId)
                            ->pluck('sku', 'id')
                            ->toArray();
                    })
                    ->afterStateUpdated(function ($state, callable $set) {
                        $variant = \App\Models\ProductVariant::find($state);
                        if ($variant) {
                            $set('price', $variant->price);
                        }
                    }),

                Forms\Components\TextInput::make('price')
                    ->label('Price')
                    ->prefix('KES')
                    ->numeric()
                    ->required()
                    ->disabled()
                    ->dehydrated(), // Ensure it's saved even if disabled

                Forms\Components\TextInput::make('quantity')
                    ->numeric()
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Product'),

                Tables\Columns\TextColumn::make('productVariant.sku')
                    ->label('Variant SKU'),

                Tables\Columns\TextColumn::make('price')
                    ->label('Unit Price')
                    ->money('KES'),

                Tables\Columns\TextColumn::make('quantity')
                    ->sortable(),

                Tables\Columns\TextColumn::make('total_cost')
                    ->label('Total')
                    ->money('KES'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
