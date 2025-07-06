<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationLabel = 'Products';
    protected static ?string $navigationGroup = 'Catalog Management';
    protected static ?int $navigationSort = 3;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\Section::make('Product Info')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Product Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(
                                        fn($state, Forms\Set $set) =>
                                        $set('slug', Str::slug($state))
                                    ),

                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->dehydrated()
                                    ->disabled()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true),

                                Forms\Components\Textarea::make('description')
                                    ->label('Product Description')
                                    ->rows(4)
                                    ->maxLength(1000),
                            ])->columnSpan(1),

                        Forms\Components\Section::make('Associations')
                            ->icon('heroicon-o-tag')
                            ->schema([
                                Forms\Components\Select::make('category_id')
                                    ->relationship('category', 'name')
                                    ->label('Category')
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                Forms\Components\Select::make('brand_id')
                                    ->relationship('brand', 'name')
                                    ->label('Brand')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                            ])->columnSpan(1),
                    ]),

                Forms\Components\Section::make('Pricing & Inventory')
                    ->icon('heroicon-o-currency-dollar')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('original_price')
                            ->label('Original Price (KES)')
                            ->required()
                            ->numeric()
                            ->prefix('KES')
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                $discount = $get('discount') ?? 0;
                                $price = $state - ($state * $discount / 100);
                                $set('price', round($price, 2));
                            }),

                        Forms\Components\TextInput::make('discount')
                            ->label('Discount (%)')
                            ->nullable()
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffix('%')
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                $original = $get('original_price') ?? 0;
                                $price = $original - ($original * $state / 100);
                                $set('price', round($price, 2));
                            }),

                        Forms\Components\TextInput::make('price')
                            ->label('Selling Price (KES)')
                            ->required()
                            ->numeric()
                            ->disabled()
                            ->dehydrated()
                            ->prefix('KES')
                            ->afterStateHydrated(function (Forms\Set $set, Forms\Get $get) {
                                $original = $get('original_price') ?? 0;
                                $discount = $get('discount') ?? 0;
                                $price = $original - ($original * $discount / 100);
                                $set('price', round($price, 2));
                            }),

                        Forms\Components\TextInput::make('stock_quantity')
                            ->label('Stock Quantity')
                            ->required()
                            ->numeric()
                            ->minValue(0),

                        Forms\Components\TextInput::make('rating')
                            ->label('Rating')
                            ->numeric()
                            ->step(0.1)
                            ->minValue(0)
                            ->maxValue(5)
                            ->suffix('/5'),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Active'),

                        Forms\Components\Toggle::make('is_featured')
                            ->label('Featured'),
                    ]),

                Forms\Components\Section::make('Product Images')
                    ->icon('heroicon-o-photo')
                    ->schema([
                        Forms\Components\FileUpload::make('main_image')
                            ->label('Main Image')
                            ->image()
                            ->imageEditor()
                            ->preserveFilenames()
                            ->directory('products')
                            ->disk('public')
                            ->imagePreviewHeight('150')
                            ->required(),

                        Forms\Components\FileUpload::make('images')
                            ->label('Gallery Images')
                            ->multiple()
                            ->reorderable()
                            ->directory('products/gallery')
                            ->disk('public')
                            ->image()
                            ->imagePreviewHeight('100'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('main_image')
                    ->label('Image')
                    ->disk('public')
                    ->circular(),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->description(fn(Product $record) => 'KES ' . number_format($record->price, 2)),

                Tables\Columns\TextColumn::make('brand.name')->label('Brand')->sortable(),
                Tables\Columns\TextColumn::make('category.name')->label('Category')->sortable(),
                Tables\Columns\TextColumn::make('original_price')->label('Original')->money('KES')->sortable(),
                Tables\Columns\TextColumn::make('discount')->label('Discount')->suffix('%')->sortable(),
                Tables\Columns\TextColumn::make('price')->label('Price')->money('KES')->sortable(),

                Tables\Columns\TextColumn::make('rating')
                    ->label('Rating')
                    ->formatStateUsing(fn($state) => $state ? number_format($state, 1) . '/5' : '-')
                    ->sortable(),

                Tables\Columns\TextColumn::make('stock_quantity')->label('Stock')->sortable(),
                Tables\Columns\IconColumn::make('is_active')->boolean()->label('Active')->sortable(),
                Tables\Columns\IconColumn::make('is_featured')->label('Featured')->boolean(),
                Tables\Columns\TextColumn::make('created_at')->label('Created')->dateTime('d M Y'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('brand')->relationship('brand', 'name'),
                Tables\Filters\SelectFilter::make('category')->relationship('category', 'name'),
                Tables\Filters\TernaryFilter::make('is_featured')->label('Featured'),
                Tables\Filters\TernaryFilter::make('is_active')->label('Active'),
                TrashedFilter::make(), // ✅ Added trashed filter here
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()->icon('heroicon-m-pencil-square'),
                Tables\Actions\DeleteAction::make()->icon('heroicon-m-trash')->color('danger'),
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\ForceDeleteAction::make()->color('danger'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
