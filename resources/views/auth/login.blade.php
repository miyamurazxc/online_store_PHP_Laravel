<x-guest-layout>
    <!-- Статус сессии -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Адрес эл. почты -->
        <div>
            <x-input-label for="email" :value="__('Электронная почта')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Пароль -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Пароль')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Запомнить меня -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded pooorbg-gray-900 border-gray-300 pooorborder-gray-700 text-orange-600 shadow-sm focus:ring-orange-500 pooorfocus:ring-orange-600 pooorfocus:ring-offset-gray-800" name="remember">
                <span class="ml-2 text-sm text-gray-600 pooortext-gray-400">{{ __('Запомнить меня') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 pooortext-gray-400 hover:text-gray-900 pooorhover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 pooorfocus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Забыли пароль?') }}
                </a>
            @endif

            <x-primary-button class="bg-orange-500 px-5 py-2 text-white font-medium rounded-3xl ml-2">
                {{ __('Войти') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

