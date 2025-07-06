<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdvertisementResource\Pages;
use App\Models\Advertisement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
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
                            ->maxLength(255),

                        Forms\Components\Select::make('product_id')
                            ->label('Associated Product')
                            ->relationship('product', 'name')
                            ->searchable()
                            ->preload(),

                        Forms\Components\TextInput::make('link')
                            ->label('External Link (Optional)')
                            ->url()
                            ->maxLength(255)
                            ->columnSpan(2),
                    ]),

                Forms\Components\Section::make('Schedule & Status')
                    ->icon('heroicon-o-calendar-days')
                    ->columns(2)
                    ->schema([
                        Forms\Components\DateTimePicker::make('starts_at')
                            ->label('Start Date')
                            ->hint('Leave blank to start immediately'),

                        Forms\Components\DateTimePicker::make('ends_at')
                            ->label('End Date')
                            ->hint('Leave blank to run indefinitely')
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
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Advertisement Image')
                    ->icon('heroicon-o-photo')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('Main Banner Image')
                            ->required()
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('advertisements')
                            ->imagePreviewHeight('150')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Image')
                    ->disk('public')
                    ->size(60)
                    ->circular(),

                Tables\Columns\TextColumn::make('title')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('product.name')
                    ->label('Product')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('starts_at')
                    ->label('Start Date')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('ends_at')
                    ->label('End Date')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
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

                Tables\Filters\TernaryFilter::make('is_active')->label('Active Status'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('toggleStatus')
                    ->label('Toggle Active')
                    ->icon('heroicon-o-power')
                    ->color(fn(Advertisement $record) => $record->is_active ? 'danger' : 'success')
                    ->action(fn(Advertisement $record) => $record->update(['is_active' => !$record->is_active])),

                Tables\Actions\DeleteAction::make(), // Hard delete
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
            'view' => Pages\ViewAdvertisement::route('/{record}'),
            'edit' => Pages\EditAdvertisement::route('/{record}/edit'),
        ];
    }
}
