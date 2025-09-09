<?php

namespace App\Filament\Resources\Students\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class StudentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('naam')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('student_number')
                    ->label('Studentnummer')
                    ->required()
                    ->unique(table: 'students', column: 'student_number'), // voorkomt dubbele nummers
            ]);
    }
}
