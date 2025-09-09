<?php

namespace App\Filament\Resources\Stages\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class StageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('titel')
                    ->required()
                    ->maxLength(255),
                Textarea::make('beschrijving')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('status')
                    ->required()
                    ->default('vrij'),
                TextInput::make('company_id')
                    ->required()
                    ->numeric(),
                TextInput::make('teacher_id')
                    ->required()
                    ->numeric(),

                // Vervanging van MultiSelect door Select()->multiple()
                Select::make('tags')
                    ->multiple()
                    ->relationship('tags', 'naam')
                    ->label('Tags')
                    ->columnSpanFull(),
            ]);
    }
}
