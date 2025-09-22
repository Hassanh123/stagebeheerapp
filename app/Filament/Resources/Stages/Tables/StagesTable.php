<?php

namespace App\Filament\Resources\Stages\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Table;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class StagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('Stage ID')
                    ->sortable(),
                TextColumn::make('titel')
                    ->label('Titel')
                    ->searchable(),
                TextColumn::make('status')
                    ->sortable(),
                TextColumn::make('company.naam')
                    ->label('Bedrijf')
                    ->sortable(),
                TextColumn::make('teacher.naam')
                    ->label('Begeleider')
                    ->sortable(),
                TagsColumn::make('tags')
                    ->label('Tags')
                    ->separator(', ')
                    ->getStateUsing(fn ($record) => $record->tags->pluck('naam')->toArray()),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
