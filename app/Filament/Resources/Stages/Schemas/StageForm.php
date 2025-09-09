<?php

namespace App\Filament\Resources\Stages\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\MultiSelect;


class StageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
             TextInput::make('title')->required(),
Textarea::make('description'),
Select::make('company_id')
    ->relationship('company', 'naam')
    ->required(),
Select::make('student_id')
    ->relationship('student', 'naam')
    ->nullable()
    ->helperText('Wordt automatisch gezet wanneer een student kiest'),
Select::make('teacher_id')
    ->relationship('teacher', 'naam')
    ->nullable(),
MultiSelect::make('tags')
    ->relationship('tags', 'name'),
Select::make('status')
    ->options([
        'vrij' => 'Vrij',
        'gekozen' => 'Gekozen',
        'akkoord' => 'Akkoord',
        'niet_akkoord' => 'Niet akkoord',
    ])
    ->default('vrij')
    ->required(),

            ]);
    }
}
