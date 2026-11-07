<?php

namespace App\Filament\Resources\Apoteks\Pages;

use App\Filament\Resources\Apoteks\ApotekResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditApotek extends EditRecord
{
    protected static string $resource = ApotekResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
