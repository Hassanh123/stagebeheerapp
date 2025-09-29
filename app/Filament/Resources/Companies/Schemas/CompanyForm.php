<?php

namespace App\Filament\Resources\Companies\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CompanyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('naam')
                    ->label('Bedrijfsnaam')
                    ->required(),

                TextInput::make('adres')
                    ->label('Adres')
                    ->required(),

                TextInput::make('contactpersoon')
                    ->label('Contactpersoon')
                    ->required(),

                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),

                TextInput::make('telefoon')
                    ->label('Telefoonnummer')
                    ->required(),

                Textarea::make('beschrijving')
                    ->label('Korte beschrijving van het bedrijf')
                    ->rows(3)
                    ->nullable(),
            ]);
    }
}
