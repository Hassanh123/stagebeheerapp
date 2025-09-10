<?php

namespace App\Filament\Resources\Stages\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\MultiSelect;
use Filament\Schemas\Schema;

class StageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('titel')
                    ->required()
                    ->columnSpanFull()
                    ->label('Titel'),
                
                Textarea::make('beschrijving')
                    ->required()
                    ->columnSpanFull()
                    ->label('Beschrijving'),
                
                Select::make('company_id')
                    ->relationship('company', 'naam')
                    ->required()
                    ->label('Bedrijf'),
                
                Select::make('student_id')
                    ->relationship('students', 'naam')
                    ->nullable()
                    ->helperText('Wordt automatisch gezet wanneer een student kiest')
                    ->label('Student'),
                
                Select::make('teacher_id')
                    ->relationship('teacher', 'naam')
                    ->nullable()
                    ->label('Begeleider'),
                
                Select::make('tags')
                    ->relationship('tags', 'naam')
                    ->label('Tags'),
                
                Select::make('status')
                    ->options([
                        'vrij' => 'Vrij',
                        'gekozen' => 'Gekozen',
                        'akkoord' => 'Akkoord',
                        'niet_akkoord' => 'Niet akkoord',
                    ])
                    ->default('vrij')
                    ->required()
                    ->label('Status'),
            ]);
    }
}
