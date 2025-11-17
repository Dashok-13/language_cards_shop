@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Заголовок -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Управління замовленнями</h1>
        <div class="space-x-4">
            <a href="{{ route('admin.products.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition duration-200">
                Управління товарами
            </a>
            <a href="{{ route('admin.dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded transition duration-200">
                Панель адміна
            </a>
        </div>
    </div>

    <!-- Повідомлення -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Фільтри -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Фільтри</h2>
        <form method="GET" action="{{ route('admin.orders.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Статус</label>
                <select name="status" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Всі статуси</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Очікує</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Обробляється</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Завершено</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Скасовано</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Оплата</label>
                <select name="payment_status" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Всі статуси</option>
                    <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Очікує</option>
                    <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Оплачено</option>
                    <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Помилка</option>
                </select>
            </div>

            <div class="flex items-end space-x-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded transition duration-200">
                    Застосувати
                </button>
                <a href="{{ route('admin.orders.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded transition duration-200">
                    Скинути
                </a>
            </div>
        </form>
    </div>

    <!-- Таблиця замовлень -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Користувач</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Сума</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Статус</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Оплата</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Дата</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Дії</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($orders as $order)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        #{{ $order->id }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $order->user->name }}</div>
                        <div class="text-sm text-gray-500">{{ $order->user->email }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ number_format($order->total_amount, 2) }} ₴
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()" 
                                    class="text-xs font-medium rounded-full px-3 py-1 border-0 focus:ring-2 focus:ring-blue-500
                                    @if($order->status == 'completed') bg-green-100 text-green-800
                                    @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                                    @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Очікує</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Обробляється</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Завершено</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Скасовано</option>
                            </select>
                        </form>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <form action="{{ route('admin.orders.update-payment-status', $order) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <select name="payment_status" onchange="this.form.submit()" 
                                    class="text-xs font-medium rounded-full px-3 py-1 border-0 focus:ring-2 focus:ring-blue-500
                                    @if($order->payment_status == 'paid') bg-green-100 text-green-800
                                    @elseif($order->payment_status == 'failed') bg-red-100 text-red-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Очікує</option>
                                <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Оплачено</option>
                                <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Помилка</option>
                            </select>
                        </form>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $order->created_at->format('d.m.Y H:i') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                        <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 hover:text-blue-900" title="Деталі">
                            <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </a>
                        <a href="{{ route('admin.orders.edit', $order) }}" class="text-green-600 hover:text-green-900" title="Редагувати">
                            <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>
                        <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" title="Видалити" onclick="return confirm('Видалити замовлення #{{ $order->id }}?')">
                                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Пустий стан -->
    @if($orders->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <p class="text-lg text-gray-600 mb-4">Замовлень не знайдено.</p>
            <a href="{{ route('admin.orders.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded transition duration-200">
                Показати всі замовлення
            </a>
        </div>
    @endif

    <!-- Пагінація -->
    @if($orders->hasPages())
        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    @endif
</div>

<!-- Стилі для селектів -->
<style>
select:focus {
    outline: none;
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
}
</style>
@endsection