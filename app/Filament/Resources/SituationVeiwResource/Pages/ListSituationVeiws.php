<?php

namespace App\Filament\Resources\SituationVeiwResource\Pages;

use App\Filament\Resources\SituationVeiwResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSituationVeiws extends ListRecords
{
    protected static string $resource = SituationVeiwResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
