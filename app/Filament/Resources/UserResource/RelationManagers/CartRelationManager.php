<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Models\ProductVariant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class CartRelationManager extends RelationManager
{
    protected static string $relationship = 'cartItems';
    protected static ?string $recordTitleAttribute = 'quantity';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('product_id')
                ->label('Product')
                ->relationship('product', 'name')
                ->searchable()
                ->preload()
                ->required()
                ->reactive()
                ->columnSpan(2),

            Forms\Components\Select::make('product_variant_id')
                ->label('Variant')
                ->options(
                    fn(callable $get) =>
                    $get('product_id')
                        ? ProductVariant::where('product_id', $get('product_id'))->pluck('sku', 'id')->toArray()
                        : []
                )
                ->disabled(fn(callable $get) => !$get('product_id'))
                ->required()
                ->searchable()
                ->placeholder('Select variant'),

            Forms\Components\TextInput::make('quantity')
                ->label('Quantity')
                ->numeric()
                ->minValue(1)
                ->required()
                ->placeholder('e.g. 2'),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('product.name')
            ->columns([
                TextColumn::make('product.name')
                    ->label('Product')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('variant.sku')
                    ->label('Variant')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('quantity')
                    ->label('Quantity')
                    ->sortable(),

                TextColumn::make('total')
                    ->label('Total Price')
                    ->money('KES')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Added At')
                    ->dateTime('M d, Y H:i')
                    ->sortable(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
