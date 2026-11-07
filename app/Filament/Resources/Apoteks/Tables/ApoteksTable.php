<?php

namespace App\Filament\Resources\Apoteks\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Filament\Resources\Apoteks\Tables\Actions\ForceDeleteBulkAction;
use App\Filament\Resources\Apoteks\Tables\Actions\RestoreBulkAction;

class ApoteksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->searchable(),
                TextColumn::make('nama')
                    ->searchable(),
                TextColumn::make('phone_number')
                    ->searchable(),
                ImageColumn::make('foto_apotek')
                    ->label('Foto Apotek')
                    ->square()
                    ->disk('public'),

                TextColumn::make('status')
                    ->searchable(),
                TextColumn::make('jam_buka')
                    ->searchable(),
                TextColumn::make('jam_tutup')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
                ForceDeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    // ForceDeleteBulkAction::make(),
                    // RestoreBulkAction::make(),
                ]),
            ]);
    }
}
