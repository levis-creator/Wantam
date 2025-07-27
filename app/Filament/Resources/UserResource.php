<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers\CartRelationManager;
use App\Filament\Resources\UserResource\RelationManagers\WishlistRelationManager;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationLabel = 'Users';
    protected static ?string $navigationGroup = 'User Management';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('User Information')
                    ->description('Enter the user\'s personal and account details.')
                    ->schema([
                        Grid::make(2)->schema([
                            Forms\Components\TextInput::make('first_name')
                                ->label('First Name')
                                ->required()
                                ->maxLength(50),
                            Forms\Components\TextInput::make('last_name')
                                ->label('Last Name')
                                ->required()
                                ->maxLength(50),
                            Forms\Components\TextInput::make('phone')
                                ->tel()
                                ->label('Phone Number')
                                ->maxLength(20),
                            Forms\Components\Select::make('role')
                                ->label('User Role')
                                ->required()
                                ->options([
                                    User::ROLE_ADMIN => 'Admin',
                                    User::ROLE_USER => 'User',
                                ])
                                ->native(false),
                            Forms\Components\TextInput::make('email')
                                ->email()
                                ->label('Email Address')
                                ->required()
                                ->maxLength(255)->columnSpan(2),
                            Forms\Components\TextInput::make('password')
                                ->label('Password')
                                ->password()
                                ->maxLength(255)
                                ->visibleOn('create'),
                        ]),
                    ])
                    ->columns(2)
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('full_name')
                    ->label('Name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('phone')
                    ->label('Phone')
                    ->formatStateUsing(fn($state) => $state ?: '—'),
                TextColumn::make('role')
                    ->label('Role')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        User::ROLE_ADMIN => 'primary',
                        User::ROLE_USER => 'success',
                        default => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Joined')
                    ->date('M d, Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make(),
                    Tables\Actions\Action::make('View')
                        ->icon('heroicon-o-eye')
                        ->color('gray')
                        ->label('Details')
                        ->url(fn(User $record): string => static::getUrl('view', ['record' => $record])),
                ])->icon('heroicon-o-cog-6-tooth')->label('Actions'),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
                BulkAction::make('restore')
                    ->label('Restore Selected')
                    ->action(fn($records) => $records->each->restore())
                    ->requiresConfirmation()
                    ->color('success')
                    ->icon('heroicon-o-arrow-path')
                    ->visible(fn() => in_array(SoftDeletes::class, class_uses_recursive(static::$model))),
            ])
            ->defaultSort('created_at', 'desc')
            ->withTrashed();
    }

    public static function getRelations(): array
    {
        return [
            CartRelationManager::class,
            WishlistRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
            'view' => Pages\ViewUser::route('/{record}'),
        ];
    }
}
