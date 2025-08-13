<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdvertisementResource\Pages;
use App\Models\Advertisement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns;
use Illuminate\Database\Eloquent\Builder;

class AdvertisementResource extends Resource
{
    protected static ?string $model = Advertisement::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';
    protected static ?string $navigationGroup = 'Marketing';
    protected static ?string $navigationLabel = 'Advertisements';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Advertisement Details')
                    ->icon('heroicon-o-megaphone')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Title')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., Sneakers & Athletic Shoes')
                            ->helperText('Enter a catchy title for the advertisement.'),

                        Forms\Components\TextInput::make('subtitle')
                            ->label('Subtitle')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., Deals and Promotions')
                            ->helperText('Enter a brief subtitle for the advertisement.'),

                        Forms\Components\TextInput::make('price')
                            ->label('Price Display')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., from $9.99')
                            ->helperText('Enter the price or discount text (e.g., "starting at 60% off").'),

                        Forms\Components\Select::make('product_id')
                            ->label('Associated Product')
                            ->relationship('product', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->helperText('Optional: Link to a specific product.'),

                        Forms\Components\TextInput::make('link')
                            ->label('External Link')
                            ->url()
                            ->maxLength(255)
                            ->nullable()
                            ->placeholder('e.g., https://example.com/category')
                            ->helperText('Optional: URL to redirect users on click.')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Images')
                    ->icon('heroicon-o-photo')
                    ->columns(2)
                    ->schema([
                        Forms\Components\FileUpload::make('image_default')
                            ->label('Default Image')
                            ->required()
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('advertisements')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(2048)
                            ->imagePreviewHeight('150')
                            ->helperText('Upload the main banner image (max 2MB, recommended 1200x600).'),

                        Forms\Components\TextInput::make('default_alt')
                            ->label('Default Image Alt Text')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., Sneakers promotion banner')
                            ->helperText('Describe the image for accessibility and SEO.'),

                        Forms\Components\FileUpload::make('image_mobile')
                            ->label('Mobile Image')
                            ->required()
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('advertisements')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(2048)
                            ->imagePreviewHeight('150')
                            ->helperText('Upload the mobile-optimized image (max 2MB, recommended 480x240).'),

                        Forms\Components\TextInput::make('mobile_alt')
                            ->label('Mobile Image Alt Text')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., Mobile sneakers promotion banner')
                            ->helperText('Describe the mobile image for accessibility and SEO.'),
                    ]),

                Forms\Components\Section::make('Schedule & Status')
                    ->icon('heroicon-o-calendar-days')
                    ->columns(2)
                    ->schema([
                        Forms\Components\DateTimePicker::make('starts_at')
                            ->label('Start Date')
                            ->native(false)
                            ->displayFormat('d M Y, H:i')
                            ->helperText('Leave blank to start immediately.'),

                        Forms\Components\DateTimePicker::make('ends_at')
                            ->label('End Date')
                            ->native(false)
                            ->displayFormat('d M Y, H:i')
                            ->helperText('Leave blank to run indefinitely.')
                            ->rules([
                                fn(Forms\Get $get): \Closure => function (string $attribute, $value, \Closure $fail) use ($get) {
                                    if ($get('starts_at') && $value && $get('starts_at') > $value) {
                                        $fail('The end date must be after the start date.');
                                    }
                                },
                            ]),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Enable to make the advertisement visible.')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Live Preview')
                    ->icon('heroicon-o-eye')
                    ->collapsible()
                    ->schema([
                        Forms\Components\Placeholder::make('preview')
                            ->label('Advertisement Preview')
                            ->content(function ($record) {
                                return view('filament.resources.advertisement.preview', ['record' => $record ?? new Advertisement()]);
                            }),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Columns\ImageColumn::make('image_default')
                    ->label('Image')
                    ->disk('public')
                    ->size(60)
                    ->circular()
                    ->getStateUsing(fn($record) => $record->image_default ?? $record->image_mobile)
                    ->extraImgAttributes(fn($record) => ['alt' => $record->default_alt ?? 'Advertisement image']),

                Columns\TextColumn::make('title')
                    ->sortable()
                    ->searchable()
                    ->wrap()
                    ->limit(30),

                Columns\TextColumn::make('subtitle')
                    ->sortable()
                    ->searchable()
                    ->wrap()
                    ->limit(30),

                Columns\TextColumn::make('price')
                    ->sortable()
                    ->searchable()
                    ->wrap()
                    ->limit(20),

                Columns\TextColumn::make('product.name')
                    ->label('Product')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Columns\TextColumn::make('starts_at')
                    ->label('Start Date')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),

                Columns\TextColumn::make('ends_at')
                    ->label('End Date')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),

                Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),

                Columns\TextColumn::make('default_alt')
                    ->label('Default Alt Text')
                    ->sortable()
                    ->searchable()
                    ->wrap()
                    ->limit(30)
                    ->toggleable(isToggledHiddenByDefault: true),

                Columns\TextColumn::make('mobile_alt')
                    ->label('Mobile Alt Text')
                    ->sortable()
                    ->searchable()
                    ->wrap()
                    ->limit(30)
                    ->toggleable(isToggledHiddenByDefault: true),

                Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('product')
                    ->relationship('product', 'name')
                    ->label('Filter by Product')
                    ->searchable()
                    ->preload(),

                Tables\Filters\Filter::make('active')
                    ->label('Currently Active')
                    ->query(
                        fn(Builder $query): Builder =>
                        $query->where('is_active', true)
                            ->where(function ($q) {
                                $now = now();
                                $q->whereNull('starts_at')->orWhere('starts_at', '<=', $now);
                            })
                            ->where(function ($q) {
                                $now = now();
                                $q->whereNull('ends_at')->orWhere('ends_at', '>=', $now);
                            })
                    ),

                Tables\Filters\Filter::make('expired')
                    ->label('Expired')
                    ->query(
                        fn(Builder $query): Builder =>
                        $query->whereNotNull('ends_at')
                            ->where('ends_at', '<', now())
                    ),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status'),

                Tables\Filters\Filter::make('date_range')
                    ->form([
                        Forms\Components\DatePicker::make('starts_from')
                            ->label('Starts From'),
                        Forms\Components\DatePicker::make('starts_until')
                            ->label('Starts Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['starts_from'], fn($q) => $q->where('starts_at', '>=', $data['starts_from']))
                            ->when($data['starts_until'], fn($q) => $q->where('starts_at', '<=', $data['starts_until']));
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['starts_from']) {
                            $indicators[] = 'Starts from: ' . $data['starts_from'];
                        }
                        if ($data['starts_until']) {
                            $indicators[] = 'Starts until: ' . $data['starts_until'];
                        }
                        return $indicators;
                    }),

                Tables\Filters\SelectFilter::make('price_range')
                    ->label('Price Range')
                    ->options([
                        'low' => 'Under $20',
                        'medium' => '$20 - $50',
                        'high' => 'Over $50',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return match ($data['value']) {
                            'low' => $query->where('price', 'like', 'from $%')->whereRaw("CAST(SUBSTRING(price FROM '\$[0-9.]+') AS DECIMAL) < 20"),
                            'medium' => $query->where('price', 'like', 'from $%')->whereRaw("CAST(SUBSTRING(price FROM '\$[0-9.]+') AS DECIMAL) BETWEEN 20 AND 50"),
                            'high' => $query->where('price', 'like', 'from $%')->whereRaw("CAST(SUBSTRING(price FROM '\$[0-9.]+') AS DECIMAL) > 50"),
                            default => $query,
                        };
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('toggleStatus')
                    ->label('Toggle Active')
                    ->icon('heroicon-o-power')
                    ->color(fn(Advertisement $record) => $record->is_active ? 'danger' : 'success')
                    ->action(fn(Advertisement $record) => $record->update(['is_active' => !$record->is_active])),
                Tables\Actions\Action::make('preview')
                    ->label('Preview')
                    ->icon('heroicon-o-eye')
                    ->modalHeading(fn($record) => $record->title ?? 'Untitled Advertisement')
                    ->modalContent(function ($record) {
                        return view('filament.resources.advertisement.preview', ['record' => $record]);
                    })
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('starts_at', 'desc');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery();
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdvertisements::route('/'),
            'create' => Pages\CreateAdvertisement::route('/create'),
            'edit' => Pages\EditAdvertisement::route('/{record}/edit'),
        ];
    }
}
