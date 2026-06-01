<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProfileController;
use App\Http\Livewire\Cart;
use App\Http\Livewire\Checkout;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Home;
use App\Http\Livewire\ProductDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Здесь описаны маршруты веб-приложения. Каждый маршрут соответствует
| определённому действию — отображению страницы или выполнению логики.
| Это основа навигации в Laravel.
*/

// Главная страница сайта (домашняя)
Route::get('/', [Home::class, 'render'])->name('home');

// Страница с деталями конкретного товара
Route::get('/product/{product_id}', [ProductDetails::class, 'render'])->name('product.details');

// Добавление товара в корзину
Route::post('/add-to-cart', [Cart::class, 'addToCart'])->name('cart.add');

// Увеличение количества товара в корзине
Route::post('/inc-qty', [Cart::class, 'incQty'])->name('qty.up');

// Уменьшение количества товара
Route::post('/dec-qty', [Cart::class, 'decQty'])->name('qty.down');

// Удаление одного товара из корзины
Route::delete('/destroy-item', [Cart::class, 'destroyItem'])->name('destroy.item');

// Очистка всей корзины
Route::delete('/destroy-cart', [Cart::class, 'destroyCart'])->name('destroy.cart');

// Просмотр содержимого корзины
Route::get('/cart', [Cart::class, 'render'])->name('cart');

// Группа маршрутов, доступных только авторизованным пользователям
Route::middleware('auth')->group(function () {

    // Страница оформления заказа (checkout)
    Route::get('/checkout', [Checkout::class, 'render'])->name('checkout');

    // Отправка формы заказа и создание записи
    Route::post('/checkout-order', [Checkout::class, 'makeOrder'])->name('checkout.order');

    // Успешная оплата (переход после оплаты)
    Route::get('/checkout-success', [Checkout::class, 'success'])->name('checkout.success');

    // Отмена оплаты
    Route::get('/checkout-cancel', [Checkout::class, 'cancel'])->name('checkout.cancel');

    // Страница редактирования профиля пользователя
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    // Сохранение обновлений профиля
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Удаление аккаунта пользователя
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Просмотр страницы личного кабинета с заказами
    Route::get('/dashboard', [Dashboard::class, 'render'])->name('dashboard');

    // Просмотр счёта (invoice) по заказу
    Route::get('/dashboard/invoice/{order}', [Dashboard::class, 'invoice'])->name('invoice');

    // Скачивание PDF-счета по заказу
    Route::get('/dashboard/invoice/pdf/{order}', [Dashboard::class, 'invoicePdf'])->name('invoice.pdf');
});

// Подключение маршрутов авторизации (login, register, reset password)
require __DIR__.'/auth.php';

