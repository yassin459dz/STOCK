<?php

namespace App\Filament\Resources\SituationResource\Pages;

use App\Filament\Resources\SituationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSituations extends ListRecords
{
    protected static string $resource = SituationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
