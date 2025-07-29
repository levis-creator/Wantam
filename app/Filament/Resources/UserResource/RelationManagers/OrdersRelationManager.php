<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Enums\OrderStatus;
use App\Filament\Resources\OrderResource;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;

class OrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'orders';
    protected static ?string $title = 'Orders';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Order ID')
                    ->copyable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn($state) => $state instanceof OrderStatus ? ucfirst($state->name) : ucfirst($state))
                    ->color(fn($state) => match ($state?->value ?? $state) {
                        'completed' => 'success',
                        'pending' => 'warning',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Payment Method')
                    ->sortable(),

                Tables\Columns\TextColumn::make('total')
                    ->label('Total (KES)')
                    ->money('KES')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ordered On')
                    ->date('M d, Y')
                    ->sortable(),
            ])
            ->actions([
                Action::make('View')
                    ->icon('heroicon-o-eye')
                    ->color('gray')
                    ->label('View')
                    ->url(fn($record) => OrderResource::getUrl('view', ['record' => $record]))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([]) // Disable bulk actions
            ->modifyQueryUsing(fn(Builder $query) => $query->with('items')) // eager load if needed
            ->paginated(true);
    }
}
