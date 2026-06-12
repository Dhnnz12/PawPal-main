<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MarketplaceController extends Controller
{
    public function index()
    {
        $products = Product::with('seller')->where('stock', '>', 0)->get();
        return view('marketplace.index', compact('products'));
    }

    public function cart()
    {
        $cart = session()->get('cart', []);
        return view('marketplace.cart', compact('cart'));
    }

    public function addToCart(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        // Check stock
        if ($product->stock < $request->quantity) {
            return back()->withErrors(['quantity' => 'Stok produk tidak mencukupi.']);
        }

        // If product already in cart, update quantity
        if (isset($cart[$product->id])) {
            $newQty = $cart[$product->id]['quantity'] + $request->quantity;
            if ($product->stock < $newQty) {
                return back()->withErrors(['quantity' => 'Stok produk tidak mencukupi untuk jumlah total di keranjang.']);
            }
            $cart[$product->id]['quantity'] = $newQty;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $request->quantity,
                'image' => $product->image,
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Produk dihapus dari keranjang!');
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'payment_proof' => 'required|file|mimes:pdf,jpg,png,jpeg|max:5120',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('marketplace.index')->withErrors(['cart' => 'Keranjang belanja Anda kosong.']);
        }

        $proofPath = null;
        if ($request->hasFile('payment_proof')) {
            $proofPath = $request->file('payment_proof')->store('payment_proofs', 'public');
        }

        // Use transactional safety
        DB::beginTransaction();
        try {
            $totalAmount = 0;
            foreach ($cart as $id => $details) {
                $totalAmount += $details['price'] * $details['quantity'];
            }

            $order = Order::create([
                'pet_owner_id' => Auth::id(),
                'status' => 'pending',
                'total_amount' => $totalAmount,
                'shipping_address' => $request->shipping_address,
                'payment_proof' => $proofPath,
            ]);

            foreach ($cart as $productId => $details) {
                $product = Product::find($productId);
                
                // Double check stock
                if ($product->stock < $details['quantity']) {
                    throw new \Exception("Stok {$product->name} tidak mencukupi.");
                }

                // Decrement stock
                $product->decrement('stock', $details['quantity']);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $details['quantity'],
                    'price' => $details['price'],
                ]);
            }

            DB::commit();
            session()->forget('cart');

            return redirect()->route('owner.dashboard')->with('success', 'Checkout berhasil! Pesanan Anda sedang diproses.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
