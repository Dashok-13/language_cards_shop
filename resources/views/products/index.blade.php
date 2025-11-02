@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Каталог карток для вивчення мов</h1>
    
    <!-- Фільтри -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4">Фільтри</h2>
        <form method="GET" action="{{ route('products.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            
            <!-- Фільтр за мовою -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Мова</label>
                <select name="language" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Всі мови</option>
                    @foreach($languages as $language)
                        <option value="{{ $language }}" {{ request('language') == $language ? 'selected' : '' }}>
                            {{ $language }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <!-- Фільтр за рівнем -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Рівень</label>
                <select name="level" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Всі рівні</option>
                    @foreach($levels as $level)
                        <option value="{{ $level }}" {{ request('level') == $level ? 'selected' : '' }}>
                            {{ $level }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <!-- Фільтр за ціною -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Мін. ціна</label>
                <input type="number" name="min_price" value="{{ request('min_price') }}" 
                       placeholder="0" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Макс. ціна</label>
                <input type="number" name="max_price" value="{{ request('max_price') }}" 
                       placeholder="1000" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <!-- Кнопки -->
            <div class="md:col-span-4 flex space-x-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md transition duration-200">
                    Застосувати фільтри
                </button>
                <a href="{{ route('products.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-md transition duration-200">
                    Скинути
                </a>
            </div>
        </form>
    </div>
    
    <!-- Сортування -->
    <div class="flex justify-between items-center mb-6">
        <div class="text-sm text-gray-600">
            Знайдено товарів: {{ $products->count() }}
        </div>
        <div class="flex space-x-4">
            <span class="text-sm text-gray-600">Сортувати:</span>
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'price', 'order' => 'asc']) }}" 
               class="text-sm {{ request('sort') == 'price' && request('order') == 'asc' ? 'text-blue-600 font-semibold' : 'text-gray-600' }}">
                Ціна ↑
            </a>
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'price', 'order' => 'desc']) }}" 
               class="text-sm {{ request('sort') == 'price' && request('order') == 'desc' ? 'text-blue-600 font-semibold' : 'text-gray-600' }}">
                Ціна ↓
            </a>
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'order' => 'asc']) }}" 
               class="text-sm {{ (!request('sort') || request('sort') == 'name') ? 'text-blue-600 font-semibold' : 'text-gray-600' }}">
                Назва А-Я
            </a>
        </div>
    </div>
    
    <!-- Продукти -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($products as $product)
            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition duration-200">
                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $product->name }}</h3>
                    <p class="text-sm text-gray-600 mb-1">Мова: {{ $product->language }}</p>
                    <p class="text-sm text-gray-600 mb-2">Рівень: {{ $product->level }}</p>
                    <p class="text-sm text-gray-600 mb-2">Карток: {{ $product->card_count }}</p>
                    <p class="text-xl font-bold text-blue-600 mb-4">{{ number_format($product->price, 2) }} ₴</p>
                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded transition duration-200">
                            Додати в кошик
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
        
        @if($products->isEmpty())
            <div class="md:col-span-3 text-center py-8">
                <p class="text-lg text-gray-600">Товари за вашими критеріями не знайдено</p>
                <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-800 mt-2 inline-block">
                    Показати всі товари
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
