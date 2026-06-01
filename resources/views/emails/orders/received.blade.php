<x-mail::message>
    <div style="background-color: #f7fafc;">
        <div style="background-color: #ffffff; max-width: 600px; margin: 0 auto; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border-radius: 4px; overflow: hidden;">
            <div style="padding: 20px;">
                <h1 style="font-size: 24px; font-weight: bold; color: #ed8936; margin-bottom: 16px;">Спасибо за ваш заказ!</h1>
                <h3>Заказ №{{$order->id}}</h3>
                <p style="color: #4a5568; margin-bottom: 16px;">
                    Мы получили ваш заказ и начали его обработку. В ближайшее время вы получите письмо с подтверждением и деталями заказа.
                </p>
                <p style="color: #4a5568; margin-bottom: 16px;">
                    Если у вас возникли вопросы или вам нужна помощь — не стесняйтесь обратиться в нашу службу поддержки.
                </p>
                <a href="{{ url('/dashboard') }}" style="background-color: #ed8936; color: #ffffff; font-weight: bold; text-decoration: none; padding: 12px 24px; border-radius: 4px; display: inline-block;">Просмотреть заказ</a>
            </div>
            <div style="background-color: #f7fafc; padding: 10px; border-radius: 10px; display: flex; justify-content: space-between; align-items: center;">
                <p style="color: #4a5568;">
                    Спасибо, {{$order->user->name}}<br>
                    {{ config('app.name') }}
                </p>
            </div>
            <a href="#" style="color: #ed8936; text-decoration: none;">Связаться с поддержкой Fazeshop</a>
        </div>
    </div>
</x-mail::message>
