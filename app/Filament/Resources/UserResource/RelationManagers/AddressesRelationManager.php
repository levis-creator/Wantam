<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class AddressesRelationManager extends RelationManager
{
    protected static string $relationship = 'addresses';
    protected static ?string $title = 'User Addresses';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Address Details')
                ->description('Provide complete address information for the user.')
                ->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Full Name')
                            ->required()
                            ->maxLength(100),

                        Forms\Components\TextInput::make('phone')
                            ->label('Phone Number')
                            ->tel()
                            ->required()
                            ->maxLength(20),

                        Forms\Components\Textarea::make('address')
                            ->label('Street Address')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('city')
                            ->label('City')
                            ->required()
                            ->maxLength(50),

                        Forms\Components\TextInput::make('postal_code')
                            ->label('Postal Code')
                            ->required()
                            ->maxLength(20),

                        Forms\Components\TextInput::make('country')
                            ->label('Country')
                            ->required()
                            ->maxLength(50),
                    ]),

                    Forms\Components\Toggle::make('is_default')
                        ->label('Set as Default Address')
                        ->helperText('This address will be used as default for orders and shipping.'),
                ])
                ->columns(2)
                ->collapsible(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('full_address')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Recipient')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable(),

                Tables\Columns\TextColumn::make('full_address')
                    ->label('Address')
                    ->wrap()
                    ->tooltip(fn($record) => $record->full_address),

                Tables\Columns\IconColumn::make('is_default')
                    ->label('Default')
                    ->boolean()
                    ->color(fn(bool $state) => $state ? 'success' : 'gray'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Added On')
                    ->date('M d, Y')
                    ->sortable()
                    ->toggleable(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Add Address')
                    ->icon('heroicon-o-plus'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn($record) => !$record->is_default), // prevent deleting default if needed
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No addresses found')
            ->emptyStateDescription('This user has not added any addresses yet.')
            ->paginated(true);
    }
}
