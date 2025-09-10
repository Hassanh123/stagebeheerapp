<?php

namespace App\Filament\Resources\Tags\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use App\Models\Stage;

class TagForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('naam')
                    ->required()
                    ->label('Naam Tag')
                    ->columnSpanFull(),

                Select::make('stages')
                    ->multiple()
                    ->relationship('stages', 'titel')
                    ->options(Stage::all()->pluck('titel', 'id')->toArray())
                    ->label('Stages')
                    ->columnSpanFull(),
            ]);
    }
}
