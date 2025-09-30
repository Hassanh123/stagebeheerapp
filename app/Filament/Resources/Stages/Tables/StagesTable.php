<?php

namespace App\Filament\Resources\Stages\Tables;

use Filament\Tables\Columns\TextColumn;
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
                    ->label('Status')
                    ->sortable(),

                TextColumn::make('company.naam')
                    ->label('Bedrijf')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('teacher.naam')
                    ->label('Begeleider')
                    ->sortable()
                    ->searchable(),

                // Tags als badges tonen (werkt bij belongsToMany)
                TextColumn::make('tags.naam')
                    ->label('Tags')
                    ->badge()
                    ->wrap(),
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
