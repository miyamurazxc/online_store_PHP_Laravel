<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class statsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $unshippedOrders = Order::where('status', '!=', 'completed')->count();
        $totalSales = Order::where('status', 'completed')->sum('total');
        $totalSalesLast30Days = Order::where('status', 'completed')
            ->where('created_at', '>=', now()->subDays(30))
            ->sum('total');

        return [
            Card::make('За последние 30 дней', '₸' . $totalSalesLast30Days)
                ->description('Продажи за последние 30 дней')
                ->color('success')
                ->icon('heroicon-o-currency-dollar'),

            Card::make('Общий доход', '₸' . $totalSales)
                ->description('Доход от завершённых заказов')
                ->color('success')
                ->icon('heroicon-o-currency-dollar'),

            Card::make('Невыполненные заказы', $unshippedOrders)
                ->description('Заказы, которые ещё не были отправлены')
                ->color('danger')
                ->icon('heroicon-o-inbox'),
        ];
    }
}
