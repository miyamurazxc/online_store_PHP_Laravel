<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\InvoiceService;
use Illuminate\Http\Request;

/**
 * Контроллер для работы со счетами (инвойсами).
 *
 * Отвечает за генерацию и отображение PDF-документов по заказам.
 * Используется сторонний сервис `InvoiceService`, который обрабатывает генерацию счёта на основе данных заказа.
 */
class InvoiceController extends Controller
{
    /**
     * Метод index отвечает за генерацию и вывод PDF-счёта для указанного заказа.
     *
     * @param Order $order — заказ, по которому формируется счёт
     * @param InvoiceService $invoiceService — сервис для создания PDF-счёта
     * @return \Symfony\Component\HttpFoundation\StreamedResponse — PDF-файл открывается в браузере
     */
    public function index(Order $order, InvoiceService $invoiceService)
    {
        return $invoiceService->createInvoice($order)->stream();
    }

    // Методы ниже являются шаблонами для CRUD-операций,
    // и могут быть реализованы при необходимости (создание, редактирование, удаление инвойсов)

    public function create() { /* Показ формы создания */ }

    public function store(Request $request) { /* Логика сохранения */ }

    public function show(Order $order) { /* Просмотр инвойса */ }

    public function edit(Order $order) { /* Редактирование инвойса */ }

    public function update(Request $request, Order $order) { /* Обновление данных */ }

    public function destroy(Order $order) { /* Удаление */ }
}

