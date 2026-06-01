<?php

namespace App\Filament\Resources\OrderItemResource\Pages;

use App\Filament\Resources\OrderItemResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOrderItems extends ListRecords
{
    protected static string $resource = OrderItemResource::class;

    protected function getTitle(): string
    {
        return 'Позиции заказов';
    }

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Добавить позицию'),
        ];
    }
}
