<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

/**
 * Контроллер, отвечающий за управление профилем пользователя:
 * просмотр, редактирование, обновление и удаление аккаунта.
 */
class ProfileController extends Controller
{
    /**
     * Метод edit отображает форму редактирования профиля.
     * Передаёт в представление текущего пользователя (авторизованного).
     *
     * @param Request $request
     * @return View — страница профиля
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Метод update обновляет данные пользователя на основе валидированного запроса.
     * Если изменён email — сбрасывает отметку о верификации.
     *
     * @param ProfileUpdateRequest $request — содержит валидированные данные
     * @return RedirectResponse — редирект обратно к профилю с сообщением об успехе
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        // Если пользователь поменял email, нужно заново верифицировать
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Метод destroy удаляет аккаунт пользователя.
     * Перед удалением проверяет пароль, разлогинивает пользователя и очищает сессию.
     *
     * @param Request $request
     * @return RedirectResponse — редирект на главную страницу
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Проверка пароля перед удалением
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Выход из аккаунта
        Auth::logout();

        // Удаление пользователя и сброс сессии
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
