<?php

namespace App\Filament\Resources\BrandResource\Pages;

use App\Filament\Resources\BrandResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components;

class ViewBrand extends ViewRecord
{
    protected static string $resource = BrandResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
            Actions\Action::make('back')
                ->label('Back to List')
                ->url($this->getResource()::getUrl('index'))
                ->icon('heroicon-o-arrow-left'),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Components\Section::make('Brand Overview')
                    ->description('Detailed view of the selected brand')
                    ->schema([
                        Components\ImageEntry::make('logo')
                            ->label('Brand Logo')
                            ->height('180px')
                            ->hiddenLabel(),

                        Components\TextEntry::make('name')
                            ->label('Brand Name')
                            ->weight('bold'),

                        Components\TextEntry::make('slug')
                            ->label('Slug'),

                        Components\IconEntry::make('is_active')
                            ->label('Status')
                            ->boolean()
                            ->trueIcon('heroicon-o-check-circle')
                            ->falseIcon('heroicon-o-x-circle')
                            ->color(fn($state) => $state ? 'success' : 'danger'),

                        Components\TextEntry::make('description')
                            ->label('Description')
                            ->columnSpanFull()
                            ->markdown(),

                        Components\TextEntry::make('created_at')
                            ->label('Created At')
                            ->dateTime()
                            ->icon('heroicon-o-calendar'),

                        Components\TextEntry::make('updated_at')
                            ->label('Last Updated')
                            ->dateTime()
                            ->icon('heroicon-o-clock'),
                    ])
                    ->columns(2),
            ]);
    }
}
