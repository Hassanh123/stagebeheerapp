<?php

namespace App\Filament\Resources\Companies\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CompaniesTable
{
    public static function configure(Table $table): Table
    {
        return $table
        ->columns([
        TextColumn::make('id')
            ->label('ID')
            ->numeric()
            ->sortable(),

        TextColumn::make('naam')
            ->label('Bedrijfsnaam')
            ->searchable(),

        TextColumn::make('adres')
            ->label('Adres')
            ->searchable(),

        TextColumn::make('contactpersoon')
            ->label('Contactpersoon')
            ->searchable(),

        TextColumn::make('email')
            ->label('Email')
            ->searchable(),

        TextColumn::make('telefoon')
            ->label('Telefoon')
            ->searchable(),

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
