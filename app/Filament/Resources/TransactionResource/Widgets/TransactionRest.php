<?php

namespace App\Filament\Resources\TransactionResource\Widgets;
use App\Models\Transaction;
use Illuminate\Support\Number;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TransactionRest extends BaseWidget
{
    protected function getStats(): array
    {
        return [

            Stat::make('Retourne Complete' , Transaction::query()->where('rest', '0')->count()),
            Stat::make('Retourné To AM', Transaction::query()->where('li_seleft', 'AM')->sum('raja3t')),
            Stat::make('Retourné To DZ', Transaction::query()->where('li_seleft', 'DZ')->sum('raja3t')),

            Stat::make('AM TO DZ', Transaction::query()->where('li_seleft', 'AM')->sum('rest')),
            Stat::make('DZ TO AM', Transaction::query()->where('li_seleft', 'DZ')->sum('rest'))->color('danger'),


        ];
    }
}
