<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';
    protected static ?string $modelLabel = 'Category';
    protected static ?string $navigationGroup = 'Catalog Management';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Category Details')->schema([
                Forms\Components\Grid::make(12)->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state)))
                        ->columnSpan(6),

                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->maxLength(255)
                        ->unique(Category::class, 'slug', ignoreRecord: true)
                        ->disabled(fn($record) => $record && $record->exists)
                        ->helperText('Automatically generated from name, but can be customized.')
                        ->columnSpan(6),

                    Forms\Components\Select::make('parent_id')
                        ->label('Parent Category')
                        ->relationship('parent', 'name', fn($query) => $query->active())
                        ->searchable()
                        ->preload()
                        ->helperText('Optional: Set if this is a subcategory')
                        ->columnSpanFull(),
                ]),

                Forms\Components\Textarea::make('description')
                    ->maxLength(500)
                    ->rows(4)
                    ->columnSpanFull(),

                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->directory('categories')
                    ->maxSize(2048)
                    ->imageEditor()
                    ->columnSpanFull(),

                Forms\Components\Grid::make(12)->schema([
                    Forms\Components\Toggle::make('is_active')
                        ->required()
                        ->default(true)
                        ->inline(false)
                        ->columnSpan(6),

                    Forms\Components\Toggle::make('is_featured')
                        ->required()
                        ->default(false)
                        ->inline(false)
                        ->helperText('Mark as featured to highlight on the frontend.')
                        ->columnSpan(6),
                ]),
            ])->collapsible(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Image')
                    ->getStateUsing(fn($record) => $record->image_url)
                    ->circular()
                    ->defaultImageUrl(asset('assets/images/placeholder.jpg')),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('parent.name')
                    ->label('Parent Category')
                    ->sortable()
                    ->searchable()
                    ->default('-')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('product_count')
                    ->label('Products')
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active')
                    ->sortable()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),

                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean()
                    ->label('Featured')
                    ->sortable()
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-star'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status')
                    ->trueLabel('Only Active')
                    ->falseLabel('Only Inactive'),

                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Featured Status')
                    ->trueLabel('Only Featured')
                    ->falseLabel('Only Non-Featured'),

                Tables\Filters\SelectFilter::make('parent_id')
                    ->label('Parent Category')
                    ->relationship('parent', 'name')
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('toggleActive')
                        ->label('Toggle Active')
                        ->action(fn($records) => $records->each->update([
                            'is_active' => fn($record) => ! $record->is_active,
                        ]))
                        ->icon('heroicon-o-power')
                        ->requiresConfirmation(),

                    Tables\Actions\BulkAction::make('toggleFeatured')
                        ->label('Toggle Featured')
                        ->action(fn($records) => $records->each->update([
                            'is_featured' => fn($record) => ! $record->is_featured,
                        ]))
                        ->icon('heroicon-o-star')
                        ->requiresConfirmation(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
