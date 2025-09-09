<?php

namespace App\Filament\Resources\Companies\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CompanyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
    ->components([
        TextInput::make('naam')
            ->required(),
        TextInput::make('adres')
            ->required(),
        TextInput::make('contactpersoon')
            ->required(),
        TextInput::make('email')
            ->label('Email address')
            ->email()
            ->required(),
        TextInput::make('telefoon')
            ->label('Telefoonnummer')
            ->required(),
    ]);

    }
}
