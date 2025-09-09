<?php

namespace App\Filament\Resources\Tags\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TagInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('naam')
                    ->label('Naam'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->label('Created At'), // label toegevoegd
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->label('Updated At'), // label toegevoegd
            ]);
    }
}
