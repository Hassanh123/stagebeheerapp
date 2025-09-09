<?php

namespace App\Filament\Resources\Students\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class StudentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                ImageEntry::make('photo_url')
                    ->label('Foto')
                    ->circular(), // Optional: makes the image circular
                TextEntry::make('student_number')
                    ->label('Studentnummer'),
                TextEntry::make('naam')
                    ->label('Naam'),
                TextEntry::make('email')
                    ->label('Email address'),
                TextEntry::make('stage.titel')
                    ->label('Gekozen Stage')
                    ->placeholder('Nog geen stage gekozen'), // Shown if no stage is linked
                TextEntry::make('created_at')
                    ->label('Aangemaakt')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->label('Bijgewerkt')
                    ->dateTime(),
            ]);
    }
}
