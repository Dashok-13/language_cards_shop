<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request; // 👈 ПЕРЕКОНАЙТЕСЯ, ЩО ЦЕ Є
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->checkAdmin();
    }

    private function checkAdmin()
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403, 'Доступ заборонено. Потрібні права адміністратора.');
        }
    }

    // 👇 ДОДАЙТЕ Request $request ЯК ПАРАМЕТР
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items.product'])->latest();
        
        // Фільтрація за статусом
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        // Фільтрація за статусом оплати
        if ($request->has('payment_status') && $request->payment_status != '') {
            $query->where('payment_status', $request->payment_status);
        }
        
        $orders = $query->paginate(15);
        
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string|in:pending,processing,completed,cancelled',
            'payment_status' => 'required|string|in:pending,paid,failed,refunded',
            'notes' => 'nullable|string'
        ]);

        $order->update($request->only(['status', 'payment_status', 'notes']));

        return redirect()->route('admin.orders.index')
            ->with('success', 'Замовлення успішно оновлено!');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Замовлення успішно видалено!');
    }

    // 👇 ДОДАЙТЕ ЦІ МЕТОДИ ДЛЯ ШВИДКОГО ОНОВЛЕННЯ СТАТУСІВ
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string|in:pending,processing,completed,cancelled'
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Статус замовлення оновлено!');
    }

    public function updatePaymentStatus(Request $request, Order $order)
    {
        $request->validate([
            'payment_status' => 'required|string|in:pending,paid,failed'
        ]);

        $order->update(['payment_status' => $request->payment_status]);

        return redirect()->back()->with('success', 'Статус оплати оновлено!');
    }
}