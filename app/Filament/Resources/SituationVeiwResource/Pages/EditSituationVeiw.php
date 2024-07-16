<?php

namespace App\Filament\Resources\SituationVeiwResource\Pages;

use App\Filament\Resources\SituationVeiwResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSituationVeiw extends EditRecord
{
    protected static string $resource = SituationVeiwResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
