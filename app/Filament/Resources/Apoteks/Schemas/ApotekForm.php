<?php

namespace App\Filament\Resources\Apoteks\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TimePicker;


class ApotekForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->required(),

                Textarea::make('deskripsi')
                    ->required(),
                Textarea::make('alamat')
                    ->required(),

                TextInput::make('phone_number')
                    ->tel()
                    ->numeric()
                    ->required()
                    ->default(null),

                FileUpload::make('foto_apotek')
                    ->label('Foto Apotek')
                    ->image()
                    ->required()
                    ->disk('public')
                    ->directory('apoteks')
                    ->visibility('public')
                    ->imageEditor()
                    ->imagePreviewHeight('200')
                    ->maxSize(2048)
                    ->nullable(),

                TextInput::make('status')
                    ->required()
                    ->default('aktif'),

                TimePicker::make('jam_buka')
                    ->required()
                    ->default(null),

                TimePicker::make('jam_tutup')
                    ->required()
                    ->default(null),
            ]);
    }
}
