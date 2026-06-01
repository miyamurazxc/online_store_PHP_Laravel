<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Класс отвечает за валидацию входных данных при обновлении профиля пользователя.
 * Используется в контроллере ProfileController::update().
 */
class ProfileUpdateRequest extends FormRequest
{
    /**
     * Метод возвращает массив правил валидации.
     * Laravel автоматически применит эти правила к соответствующим полям формы.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            // Имя должно быть строкой, не длиннее 255 символов
            'name' => ['string', 'max:255'],

            // Email должен быть валидным, уникальным (кроме текущего пользователя), не длиннее 255 символов
            'email' => [
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id) // исключаем текущего пользователя при проверке уникальности
            ],
        ];
    }
}

