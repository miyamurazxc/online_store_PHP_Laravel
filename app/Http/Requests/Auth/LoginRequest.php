<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/**
 * Этот класс обрабатывает и валидирует входящие данные при попытке входа пользователя в систему.
 * Используется в методах аутентификации (например, AuthController).
 */
class LoginRequest extends FormRequest
{
    /**
     * Авторизация запроса — здесь всегда true, т.к. доступ к форме логина открыт для всех.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Правила валидации формы логина:
     * - email обязателен, должен быть строкой и соответствовать формату email.
     * - password обязателен, строка.
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Метод отвечает за сам процесс аутентификации.
     * - Проверяет, не превышен ли лимит попыток входа.
     * - Выполняет попытку входа через Auth::attempt.
     * - В случае неудачи: увеличивает счётчик попыток и выбрасывает ValidationException.
     * - В случае успеха: очищает лимит попыток.
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited(); // проверка лимита попыток

        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey()); // увеличиваем количество попыток

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'), // выводим сообщение об ошибке
            ]);
        }

        RateLimiter::clear($this->throttleKey()); // сбрасываем счётчик попыток
    }

    /**
     * Проверка на превышение лимита попыток входа.
     * Если превышен — событие блокировки и сообщение с таймером ожидания.
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this)); // событие блокировки

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Генерация уникального ключа на основе email и IP-адреса.
     * Этот ключ используется для отслеживания попыток входа (Rate Limiting).
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('email')).'|'.$this->ip());
    }
}
