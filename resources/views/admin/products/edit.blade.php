@extends('admin.layout')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-2xl font-bold text-gray-800">Редагувати картку</h2>
    </div>

    <div class="p-6">
        <form action="{{ route('admin.products.update', $product) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Назва -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Назва *</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" 
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Мова -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Мова *</label>
                    <input type="text" name="language" value="{{ old('language', $product->language) }}" 
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                    @error('language') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Рівень -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Рівень *</label>
                    <select name="level" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="Початковий" {{ old('level', $product->level) == 'Початковий' ? 'selected' : '' }}>Початковий</option>
                        <option value="Середній" {{ old('level', $product->level) == 'Середній' ? 'selected' : '' }}>Середній</option>
                        <option value="Просунутий" {{ old('level', $product->level) == 'Просунутий' ? 'selected' : '' }}>Просунутий</option>
                    </select>
                    @error('level') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Ціна -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ціна (₴) *</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" 
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                    @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Кількість карток -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Кількість карток *</label>
                    <input type="number" name="card_count" value="{{ old('card_count', $product->card_count) }}" 
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                    @error('card_count') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Зображення -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Зображення (шлях) *</label>
                    <input type="text" name="image" value="{{ old('image', $product->image) }}" 
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="images/product.jpg" required>
                    @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Опис -->
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Опис *</label>
                <textarea name="description" rows="4" 
                          class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                          required>{{ old('description', $product->description) }}</textarea>
                @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Кнопки -->
            <div class="mt-6 flex space-x-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded transition">
                    Оновити картку
                </button>
                <a href="{{ route('admin.products.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded transition">
                    Скасувати
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
