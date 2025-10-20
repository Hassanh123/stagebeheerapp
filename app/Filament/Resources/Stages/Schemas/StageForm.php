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
                    ->relationship(name: 'company', titleAttribute: 'naam')
                    ->required()
                    ->label('Bedrijf'),

                Select::make('teacher_id')
                    ->relationship(name: 'teacher', titleAttribute: 'naam')
                    ->nullable()
                    ->label('Begeleider'),

                Select::make('tags')
                    ->label('Tags')
                    ->relationship(name: 'tags', titleAttribute: 'naam')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->columnSpanFull(),

                // ✅ Correcte status opties
                Select::make('status')
                    ->options([
                        'vrij' => 'Vrij',
                        'in_behandeling' => 'In behandeling',
                        'goedgekeurd' => 'Goedgekeurd',
                        'afgekeurd' => 'Afgekeurd',
                    ])
                    ->default('vrij')
                    ->required()
                    ->label('Status'),
            ]);
    }
}
