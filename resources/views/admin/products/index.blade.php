@extends('admin.layout')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">Управління картками</h2>
            <a href="{{ route('admin.products.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition">
                Додати картку
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Зображення</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Назва</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Мова</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Рівень</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ціна</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Дії</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($products as $product)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="h-10 w-10 rounded-full object-cover">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product->language }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product->level }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($product->price, 2) }} ₴</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                        <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600 hover:text-blue-900">Редагувати</a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Видалити цю картку?')">Видалити</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
