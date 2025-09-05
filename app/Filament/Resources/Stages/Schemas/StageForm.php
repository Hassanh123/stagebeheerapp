<?php

namespace App\Filament\Resources\Stages\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class StageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('stage_id')
                    ->required()
                    ->numeric(),
                TextInput::make('titel')
                    ->tel()
                    ->required(),
                Textarea::make('beschrijving')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('status')
                    ->required(),
                TextInput::make('bedrijf_id')
                    ->required()
                    ->numeric(),
            ]);
    }
}
