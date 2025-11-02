@props(['title','price','image','id','language','level'])
<div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
    <img src="{{ asset($image) }}" alt="{{ $title }}" class="w-full h-48 object-cover">
    <div class="p-4">
        <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $title }}</h3>
        @if($language)
            <p class="text-sm text-gray-600 mb-1">Мова: {{ $language }}</p>
        @endif
        @if($level)
            <p class="text-sm text-gray-600 mb-2">Рівень: {{ $level }}</p>
        @endif
        <p class="text-xl font-bold text-blue-600 mb-4">{{ number_format($price, 2) }} ₴</p>
        <form action="{{ route('cart.add', $id) }}" method="POST">
            @csrf
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded transition duration-200">
                Додати в кошик
            </button>
        </form>
    </div>
</div>