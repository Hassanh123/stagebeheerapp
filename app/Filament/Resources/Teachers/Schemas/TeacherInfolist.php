<?php

namespace App\Filament\Resources\Teachers\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TeacherInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('naam'),
                TextEntry::make('email')
                    ->label('Email address'),

                // Stages die deze docent begeleidt
                TextEntry::make('stages')
                    ->label('Stages')
                    ->getStateUsing(fn ($record) => $record->stages->pluck('titel')->implode(', ')),

                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
