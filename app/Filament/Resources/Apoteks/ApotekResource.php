<?php

namespace App\Filament\Resources\Apoteks;

use App\Filament\Resources\Apoteks\Pages\CreateApotek;
use App\Filament\Resources\Apoteks\Pages\EditApotek;
use App\Filament\Resources\Apoteks\Pages\ListApoteks;
use App\Filament\Resources\Apoteks\Schemas\ApotekForm;
use App\Filament\Resources\Apoteks\Tables\ApoteksTable;
use App\Models\Apotek;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ApotekResource extends Resource
{
    protected static ?string $model = Apotek::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'apotek';

    public static function form(Schema $schema): Schema
    {
        return ApotekForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ApoteksTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListApoteks::route('/'),
            'create' => CreateApotek::route('/create'),
            'edit' => EditApotek::route('/{record}/edit'),
        ];
    }
}
