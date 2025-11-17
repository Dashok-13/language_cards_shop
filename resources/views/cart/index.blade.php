@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Мій кошик</h1>
    
    @if(empty($cart))
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <p class="text-lg text-gray-600 mb-4">Ваш кошик порожній.</p>
            <a href="{{ route('products.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded transition duration-200">
                Перейти до покупок
            </a>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Товар</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Кількість</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ціна</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Разом</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($cart as $id => $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $item['name'] }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item['quantity'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($item['price'], 2) }} ₴</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ number_format($item['price'] * $item['quantity'], 2) }} ₴</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('cart.remove', $id) }}" class="text-red-600 hover:text-red-900">Видалити</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div class="bg-gray-50 px-6 py-4">
                <div class="flex justify-between items-center">
                    <div class="text-lg font-semibold text-gray-900">
                        Загальна сума: {{ number_format($total, 2) }} ₴
                    </div>
                    <div class="space-x-4">
                        <form action="{{ route('cart.clear') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-6 rounded transition duration-200">
                                Очистити кошик
                            </button>
                        </form>

                        <form action="{{ route('cart.checkout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-6 rounded transition duration-200"
                                    onclick="return confirm('Ви впевнені, що хочете оформити замовлення?')">
                                Оформити замовлення
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection