<?php

namespace App\Filament\Resources\Stages\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
    ->columns([
    TextColumn::make('id')
        ->label('Stage ID')
        ->numeric()
        ->sortable(),

    TextColumn::make('titel')
        ->label('Titel')
        ->searchable(),

    TextColumn::make('status')
        ->label('Status')
        ->searchable(),

    TextColumn::make('company_id')
        ->label('Bedrijf')
        ->numeric()
        ->sortable(),

    TextColumn::make('teacher_id')
        ->label('Begeleider')
        ->numeric()
        ->sortable(),

    TextColumn::make('created_at')
        ->label('Aangemaakt')
        ->dateTime()
        ->sortable()
        ->toggleable(isToggledHiddenByDefault: true),

    TextColumn::make('updated_at')
        ->label('Bijgewerkt')
        ->dateTime()
        ->sortable()
        ->toggleable(isToggledHiddenByDefault: true),
])
            ->filters([
                //
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
