<?php

namespace App\Filament\Resources\Branches\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class BranchForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->required(),

                Select::make('jenis')
                    ->label('Jenis Lokasi')
                    ->options([
                        'toko' => 'Toko',
                        'bengkel' => 'Bengkel',
                    ])
                    ->default('toko')
                    ->required(),

                Textarea::make('alamat')
                    ->label('Alamat Cabang')
                    ->required(),

                TextInput::make('telepon')
                    ->tel()
                    ->default(null),

                TextInput::make('latitude')
                    ->required()
                    ->numeric()
                    ->minValue(-90)
                    ->maxValue(90)
                    ->helperText('Latitude must be between -90 and 90 degrees.'),

                TextInput::make('longitude')
                    ->required()
                    ->numeric()
                    ->minValue(-180)
                    ->maxValue(180)
                    ->helperText('Longitude must be between -180 and 180 degrees.'),
            ]);
    }
}
