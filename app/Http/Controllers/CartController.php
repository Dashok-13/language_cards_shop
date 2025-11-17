<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Order;  
use App\Models\OrderItem;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
        return view('cart.index', compact('cart', 'total'));
    }

    public function addToCart($id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->image
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Товар додано до кошика!');
    }

    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);
        
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Товар видалено з кошика!');
    }

    public function clearCart()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Кошик очищено!');
    }
public function checkout(Request $request)
{
    $cart = session()->get('cart', []);
    
    if (empty($cart)) {
        return redirect()->route('cart.index')->with('error', 'Кошик порожній!');
    }

    // Створюємо нове замовлення
    $order = Order::create([
        'user_id' => auth()->id(),
        'total_amount' => array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart)),
        'status' => 'pending',
        'payment_status' => 'pending',
    ]);

    // Додаємо товари до замовлення
    foreach ($cart as $id => $item) {
        $order->items()->create([
            'product_id' => $id,
            'quantity' => $item['quantity'],
            'price' => $item['price'],
        ]);
    }

    // Очищаємо кошик
    session()->forget('cart');

    return redirect()->route('cart.index')
        ->with('success', 'Замовлення #' . $order->id . ' оформлено! Дякуємо за покупку!');
}
}