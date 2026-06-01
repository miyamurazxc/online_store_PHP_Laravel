<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-end mb-4">
            <a href="{{ route('invoice.pdf', $order) }}" target="__blank" class="btn">
                Скачать счёт (PDF)
            </a>
        </div>

        <div class="bg-orange-100/40 p-8 rounded-3xl">
            <header class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-5xl font-bold text-orange-600">Счёт</h1>
                    <p class="text-md">Счёт №{{ $order->id }}</p>
                </div>
                <div>
                    <p class="text-orange-600 font-semibold">Fazeshop</p>
                    <p>Tetouan Shore, ISMO</p>
                    <p>Tetouan</p>
                    <p>sanzhar.muratov.05@gmail.com</p>
                </div>
            </header>

            <div class="mb-8 text-lg">
                <p class="text-orange-600 font-semibold mb-2 text-xl">Покупатель:</p>
                <p><strong>Имя</strong>: {{ ucfirst($order->user->name) }}</p>
                <p><strong>Телефон</strong>: {{ ucfirst($order->user->billingDetails->phone) }}</p>
                <p><strong>Адрес</strong>: {{ ucfirst($order->user->billingDetails->billing_address) }}</p>
                <p>
                    <strong>Город</strong>: {{ ucfirst($order->user->billingDetails->city) }},
                    <strong>Область</strong>: {{ ucfirst($order->user->billingDetails->state) }}
                </p>
            </div>

            <table class="w-full text-left table-auto bg-white/60">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-orange-600">Изображение</th>
                        <th class="px-4 py-2 text-orange-600">Наименование</th>
                        <th class="px-4 py-2 text-orange-600">Кол-во</th>
                        <th class="px-4 py-2 text-orange-600">Цена</th>
                        <th class="px-4 py-2 text-orange-600">Сумма</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderItems as $item)
                        <tr class="text-lg">
                            <td class="px-4 py-2">
                                <a href="{{ route('product.details', $item->product->id) }}">
                                    <img src="{{ asset('storage/' . $item->product->image) }}" class="w-40 h-40 mr-4 rounded">
                                </a>
                            </td>
                            <td class="px-4 py-2">
                                <p class="font-medium text-lg mb-2">&bullet; {{ $item->product->name }}</p>
                                <p>{{ $item->product->brief_description }}</p>
                            </td>
                            <td class="px-4 py-2">{{ $item->quantity }}</td>
                            <td class="px-4 py-2">₸{{ $item->product->price }}</td>
                            <td class="px-4 py-2">₸{{ $item->product->price * $item->quantity }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="text-lg">
                    <tr class="font-semibold">
                        <td colspan="4" class="px-4 py-2 text-right">Промежуточный итог:</td>
                        <td class="px-4 py-2">₸{{ $order->total }}</td>
                    </tr>
                    <tr class="font-semibold text-orange-600">
                        <td colspan="4" class="px-4 py-2 text-right">Итого:</td>
                        <td class="px-4 py-2">₸{{ $order->total }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</x-app-layout>
