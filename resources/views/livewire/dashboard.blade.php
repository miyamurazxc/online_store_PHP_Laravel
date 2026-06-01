{{-- Используется основной макет приложения --}}
<x-app-layout>
    
    {{-- Слот для заголовка страницы --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Панель пользователя') }}
        </h2>
    </x-slot>

    {{-- Основной контейнер с отступами --}}
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold mb-6">Панель пользователя</h1>

        {{-- Проверка: если у пользователя есть хотя бы один заказ --}}
        @if ($orders->count())
            {{-- Карточка с таблицей заказов --}}
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4">Ваши последние заказы</h2>

                {{-- Таблица заказов --}}
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="text-left font-semibold border-b">
                            <th class="pb-2">Номер заказа</th>
                            <th class="pb-2">Дата</th>
                            <th class="pb-2">Сумма</th>
                            <th class="pb-2">Статус</th>
                            <th class="pb-2">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Выводим каждый заказ в отдельной строке --}}
                        @foreach ($orders as $order)
                            <tr class="border-b">
                                <td class="py-2">{{ $order->id }}</td>
                                <td class="py-2">{{ $order->created_at->format('d.m.Y') }}</td>
                                <td class="py-2">₸{{ $order->total }}</td>
                                <td class="py-2">
                                    {{-- Условие для показа статуса заказа --}}
                                    @if ($order->status === 'completed')
                                        <span class="text-green-600">Завершён</span>
                                    @else
                                        <span class="text-yellow-600">В обработке</span>
                                    @endif
                                </td>
                                <td class="py-2">
                                    {{-- Ссылки на просмотр счёта и скачивание PDF --}}
                                    <a href="{{ route('invoice.view', $order) }}" class="text-blue-600 hover:underline">
                                        Просмотр счёта
                                    </a>
                                    |
                                    <a href="{{ route('invoice.pdf', $order) }}" class="text-purple-600 hover:underline">
                                        Скачать PDF
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Элементы пагинации, если заказов много --}}
                <div class="mt-4">
                    {{ $orders->links() }}
                </div>
            </div>
        @else
            {{-- Сообщение, если заказов нет --}}
            <div class="text-gray-600">
                У вас пока нет заказов.
            </div>
        @endif
    </div>
</x-app-layout>

