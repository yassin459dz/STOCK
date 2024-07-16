<?php

namespace App\Filament\Resources\SituationResource\Pages;

use App\Filament\Resources\SituationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSituation extends EditRecord
{
    protected static string $resource = SituationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
