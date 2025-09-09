<?php

namespace App\Filament\Resources\Stages\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class StageInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->numeric(),
                TextEntry::make('titel'),
                TextEntry::make('beschrijving'),
                TextEntry::make('status'),
                TextEntry::make('company_id')
                    ->numeric(),
                TextEntry::make('teacher_id')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
