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
    // Bind the resource to the Product model
    protected static ?string $model = Product::class;

    // Sidebar navigation settings
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationLabel = 'Products';
    protected static ?string $navigationGroup = 'Catalog Management';
    protected static ?int $navigationSort = 3;

    /**
     * Define the form used to create or edit a product
     */
    public static function form(Form $form): Form
    {
        return $form->schema([
            // Basic Product Info and Associations in Grid layout
            Forms\Components\Grid::make(2)->schema([
                // Left Column - Product Info
                Forms\Components\Section::make('Product Info')
                    ->icon('heroicon-o-information-circle')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Product Name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn($state, Forms\Set $set) => $set('slug', Str::slug($state)))
                            ->hint('This is the title customers will see.'),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->dehydrated()
                            ->disabled()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->hint('Auto-generated from name'),

                        Forms\Components\Textarea::make('description')
                            ->label('Product Description')
                            ->rows(4)
                            ->maxLength(1000)
                            ->hint('Short description shown on product detail page'),
                    ])->columnSpan(1),

                // Right Column - Associations
                Forms\Components\Section::make('Associations')
                    ->icon('heroicon-o-tag')
                    ->schema([
                        Forms\Components\Select::make('category_id')
                            ->relationship('category', 'name')
                            ->label('Category')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->hint('Assign a category to help filter products'),

                        Forms\Components\Select::make('brand_id')
                            ->relationship('brand', 'name')
                            ->label('Brand')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->hint("Choose the product's brand"),
                    ])->columnSpan(1),
            ]),

            // Product Variants (Repeater section)
            Forms\Components\Section::make('Product Variants')
                ->icon('heroicon-o-squares-plus')
                ->schema([
                    Forms\Components\Repeater::make('variants')
                        ->relationship()
                        ->label('Product Variants')
                        ->schema([
                            Forms\Components\Select::make('size_id')
                                ->relationship('size', 'label')
                                ->required()
                                ->label('Size')
                                ->searchable()
                                ->preload()
                                ->placeholder('Select a size')
                                ->createOptionForm([
                                    Forms\Components\TextInput::make('name')
                                        ->required()
                                        ->label('Size Name')
                                        ->placeholder('e.g., Extra Large')
                                        ->hint('Full name of the size (e.g., Small, Medium, Large)'),

                                    Forms\Components\TextInput::make('label')
                                        ->required()
                                        ->label('Label')
                                        ->placeholder('e.g., XL')
                                        ->hint('Short label used in product listings'),
                                ]),


                            Forms\Components\Select::make('color_id')
                                ->relationship('color', 'name')
                                ->required()
                                ->label('Color')
                                ->searchable()
                                ->preload()
                                ->placeholder('Select a color')
                                ->createOptionForm([
                                    Forms\Components\TextInput::make('name')
                                        ->required()
                                        ->label('Color Name')
                                        ->placeholder('e.g., Midnight Blue')
                                        ->hint('Readable name of the color shown to customers'),

                                    Forms\Components\TextInput::make('hex')
                                        ->required()
                                        ->label('HEX Code')
                                        ->type('color')
                                        ->hint('Select a color or enter a hex code')
                                        ->prefix('#')
                                        ->default('#000000'),

                                ]),

                            Forms\Components\TextInput::make('sku')
                                ->label('SKU')
                                ->required()
                                ->hint('Unique identifier for variant'),

                            Forms\Components\TextInput::make('price')
                                ->label('Price')
                                ->numeric()
                                ->required()
                                ->prefix('KES')
                                ->hint('Selling price of this variant'),

                            Forms\Components\TextInput::make('stock')
                                ->label('Stock')
                                ->numeric()
                                ->required()
                                ->hint('Total available units'),
                        ])
                        ->columns(3)
                        ->addActionLabel('Add Variant')
                        ->reorderable()
                        ->defaultItems(1),
                ]),

            // Toggles and product rating
            Forms\Components\Section::make('Additional Settings')
                ->icon('heroicon-o-cog-6-tooth')
                ->columns(2)
                ->schema([
                    Forms\Components\Toggle::make('is_active')->label('Active')->hint('Enable to make product visible')->default(true),
                    Forms\Components\Toggle::make('is_featured')->label('Featured')->hint('Mark as featured product'),
                    Forms\Components\TextInput::make('rating')
                        ->label('Rating')
                        ->numeric()
                        ->step(0.1)
                        ->minValue(0)
                        ->maxValue(5)
                        ->suffix('/5')
                        ->hint('Average customer rating'),
                ]),

            // File uploads for main and gallery images
            Forms\Components\Section::make('Product Images')
                ->icon('heroicon-o-photo')
                ->schema([
                    Forms\Components\FileUpload::make('main_image')
                        ->label('Main Image')                    // Display label
                        ->image()                                // Restrict upload to image types
                        ->imageEditor()                          // Enable cropping, flipping, rotating, etc.
                        ->preserveFilenames()                    // Keep original file name (optional for SEO-friendly naming)
                        ->directory('products/main')             // Store in 'storage/app/public/products/main'
                        ->disk('public')                         // Use 'public' disk (must be configured in `filesystems.php`)
                        ->imagePreviewHeight('150')              // Set preview height (good for UI consistency)
                        ->maxSize(2048)                          // Optional: Limit file size (in KB)
                        ->required(),

                    Forms\Components\FileUpload::make('images')
                        ->label('Gallery Images')
                        ->multiple()
                        ->reorderable()
                        ->directory('products/gallery')
                        ->disk('public')
                        ->image()
                        ->imagePreviewHeight('100')
                        ->hint('Optional additional views of the product'),
                ]),
        ]);
    }

    /**
     * Define the table view for listing products
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Product main image
                Tables\Columns\ImageColumn::make('main_image')
                    ->label('Image')
                    ->disk('public')
                    ->circular(),

                // Name + Price
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->description(fn(Product $record) => 'KES ' . number_format($record->price, 2)),

                // Brand and Category
                Tables\Columns\TextColumn::make('brand.name')->label('Brand')->sortable()->badge(),
                Tables\Columns\TextColumn::make('category.name')->label('Category')->sortable()->badge(),

                // Rating
                Tables\Columns\TextColumn::make('rating')
                    ->label('Rating')
                    ->formatStateUsing(fn($state) => $state ? number_format($state, 1) . '/5' : '-')
                    ->sortable(),

                // Summed stock from variants
                Tables\Columns\TextColumn::make('variants_sum_stock')
                    ->label('Total Stock')
                    ->sortable()
                    ->getStateUsing(fn(Product $record) => $record->variants->sum('stock')),

                // Boolean columns
                Tables\Columns\IconColumn::make('is_active')->boolean()->label('Active')->sortable(),
                Tables\Columns\IconColumn::make('is_featured')->label('Featured')->boolean(),

                // Created date
                Tables\Columns\TextColumn::make('created_at')->label('Created')->dateTime('d M Y'),
            ])
            ->filters([
                // Filters for brand, category, toggles, and soft deletes
                Tables\Filters\SelectFilter::make('brand')->relationship('brand', 'name'),
                Tables\Filters\SelectFilter::make('category')->relationship('category', 'name'),
                Tables\Filters\TernaryFilter::make('is_featured')->label('Featured'),
                Tables\Filters\TernaryFilter::make('is_active')->label('Active'),
                TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make()->icon('heroicon-m-pencil-square'),
                    Tables\Actions\DeleteAction::make()->icon('heroicon-m-trash')->color('danger'),
                    Tables\Actions\RestoreAction::make(),
                    Tables\Actions\ForceDeleteAction::make()->color('danger'),
                ]),
            ])

            ->bulkActions([
                // Bulk actions group
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    /**
     * Customize the Eloquent query used for this resource
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ])
            ->with(['variants']); // Eager load variants to optimize stock sum
    }

    /**
     * Define additional relations (none for now)
     */
    public static function getRelations(): array
    {
        return [];
    }

    /**
     * Define page routes for this resource
     */
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
