<?php

namespace App\Filament\Resources\Stages\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
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

                Select::make('teacher_id')
                    ->relationship('teacher', 'naam')
                    ->nullable()
                    ->label('Begeleider')
                    ->helperText('Koppel hier een docent als de stage akkoord is.'),

                // Tags: belongsToMany -> gebruik relationship() + multiple()
                Select::make('tags')
                    ->label('Tags')
                    ->relationship('tags', 'naam')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->columnSpanFull(),

                Select::make('status')
                    ->options([
                        'vrij' => 'Vrij',
                        'in_behandeling' => 'In behandeling',
                        'goedgekeurd' => 'Goedgekeurd',
                        'afgekeurd' => 'Afgekeurd',
                    ])
                    ->default('vrij')
                    ->required()
                    ->label('Status')
                
            ]);
    }
}
