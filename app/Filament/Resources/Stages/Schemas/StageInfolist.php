<?php

namespace App\Filament\Resources\Stages\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\TagsEntry;
use Filament\Schemas\Schema;

class StageInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
    
            TextEntry::make('titel')->label('Titel'),
            TextEntry::make('beschrijving')->label('Beschrijving')->columnSpanFull(),
            TextEntry::make('status')->label('Status'),
            TextEntry::make('company.naam')->label('Bedrijf'),
            TextEntry::make('company.adres')->label('Locatie'), // ✅ Show company location
            TextEntry::make('teacher.naam')->label('Begeleider'),
            //TagsEntry::make('tags')->label('Tags')->relationship('tags', 'naam'),
            TextEntry::make('created_at')->label('Gemaakt op')->dateTime(),
            TextEntry::make('updated_at')->label('Bijgewerkt op')->dateTime(),
        ]);
    }
}
