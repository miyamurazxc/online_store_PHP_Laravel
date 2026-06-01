<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Всего заказов', Order::count())
                ->description('Общее количество заказов')
                ->color('primary'),

            Card::make('Завершено', Order::where('status', 'completed')->count())
                ->description('Успешно выполнено')
                ->color('success'),

            Card::make('В обработке', Order::where('status', 'processing')->count())
                ->description('Текущие заказы')
                ->color('warning'),
        ];
    }
}
