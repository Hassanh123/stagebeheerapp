<?php

namespace App\Filament\Resources\Companies\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CompanyInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('naam')
                    ->label('Bedrijfsnaam'),

                TextEntry::make('adres')
                    ->label('Adres'),

                TextEntry::make('contactpersoon')
                    ->label('Contactpersoon'),

                TextEntry::make('email')
                    ->label('Email address'),

                TextEntry::make('beschrijving')
                    ->label('Beschrijving'),

                TextEntry::make('created_at')
                    ->label('Aangemaakt op')
                    ->dateTime(),

                TextEntry::make('updated_at')
                    ->label('Laatst bijgewerkt')
                    ->dateTime(),
            ]);
    }
}
