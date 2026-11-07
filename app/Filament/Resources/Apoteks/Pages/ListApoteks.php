<?php

namespace App\Filament\Resources\Apoteks\Pages;

use App\Filament\Resources\Apoteks\ApotekResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListApoteks extends ListRecords
{
    protected static string $resource = ApotekResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
