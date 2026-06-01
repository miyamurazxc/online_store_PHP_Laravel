<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * Базовый контроллер, от которого наследуются все остальные контроллеры в проекте.
 * 
 * Использует трейт `AuthorizesRequests` для проверки прав доступа (например, policies),
 * и `ValidatesRequests` — для удобной валидации входящих данных из форм.
 * 
 * Позволяет централизованно использовать общую логику, если понадобится (например, middleware, shared methods).
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
