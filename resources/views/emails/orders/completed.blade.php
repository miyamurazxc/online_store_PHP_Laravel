<x-mail::message>
# Ваш заказ был завершён

Ваш заказ №{{ $order->id }} был отправлен.

Благодарим за покупку!

<a href="{{ url('/dashboard') }}"
   style="background-color: #ed8936; color: #ffffff; font-weight: bold; text-decoration: none; padding: 12px 24px; border-radius: 4px; display: inline-block;">
    Просмотреть заказ
</a>

С уважением,<br>
{{ config('app.name') }}
</x-mail::message>

