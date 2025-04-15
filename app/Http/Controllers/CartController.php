<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Display the shopping cart.
     */
    public function index()
    {
        // Fix existing cart items to ensure they have the correct image paths
        $this->fixCartImagePaths();
        
        $cart = Session::get('cart', []);
        $totals = $this->calculateTotals();
        
        return view('cart.index', compact('cart', 'totals'));
    }

    /**
     * Fix cart image paths to ensure correct format
     */
    private function fixCartImagePaths()
    {
        $cart = Session::get('cart', []);
        $updated = false;
        
        foreach ($cart as $id => $item) {
            // If the image path doesn't already contain 'storage/', prepend it
            if (!str_contains($item['image'], 'storage/')) {
                $cart[$id]['image'] = 'storage/' . $item['image'];
                $updated = true;
            }
        }
        
        if ($updated) {
            Session::put('cart', $cart);
        }
    }

    /**
     * Add a product to the cart.
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);
        $cart = Session::get('cart', []);

        // Check if product exists in cart
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $request->quantity;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->on_sale && $product->sale_price ? $product->sale_price : $product->price,
                'quantity' => $request->quantity,
                'image' => 'storage/' . $product->image
            ];
        }

        Session::put('cart', $cart);
        
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    /**
     * Update the cart quantities.
     */
    public function update(Request $request)
    {
        $request->validate([
            'quantity' => 'required|array',
            'quantity.*' => 'required|numeric|min:1'
        ]);

        $cart = Session::get('cart', []);
        
        foreach ($request->quantity as $productId => $quantity) {
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] = $quantity;
            }
        }
        
        Session::put('cart', $cart);
        
        return redirect()->route('cart.index')->with('success', 'Cart updated successfully!');
    }

    /**
     * Remove a product from the cart.
     */
    public function remove($id)
    {
        $cart = Session::get('cart', []);
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
        }
        
        return redirect()->route('cart.index')->with('success', 'Product removed from cart!');
    }

    /**
     * Clear the cart.
     */
    public function clear()
    {
        Session::forget('cart');
        Session::forget('coupon');
        
        return redirect()->route('cart.index')->with('success', 'Cart cleared successfully!');
    }

    /**
     * Apply coupon to cart.
     */
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|exists:coupons,code'
        ]);

        $coupon = Coupon::where('code', $request->code)->first();
        
        if (!$coupon->isValid()) {
            return redirect()->back()->with('error', 'This coupon is invalid or expired.');
        }
        
        // Check minimum order amount
        $cartTotal = $this->calculateCartTotal();
        if ($coupon->min_order_amount && $cartTotal < $coupon->min_order_amount) {
            return redirect()->back()->with('error', 'Your order does not meet the minimum amount for this coupon.');
        }
        
        Session::put('coupon', [
            'code' => $coupon->code,
            'discount' => $coupon->calculateDiscount($cartTotal)
        ]);
        
        return redirect()->back()->with('success', 'Coupon applied successfully!');
    }

    /**
     * Remove coupon from cart.
     */
    public function removeCoupon()
    {
        Session::forget('coupon');
        
        return redirect()->route('cart.index')->with('success', 'Coupon removed successfully!');
    }

    /**
     * Calculate the cart total (without shipping or discount).
     */
    private function calculateCartTotal()
    {
        $total = 0;
        $cart = Session::get('cart', []);
        
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return $total;
    }

    /**
     * Calculate all cart totals.
     */
    private function calculateTotals()
    {
        $subtotal = $this->calculateCartTotal();
        $shipping = 0; // Default, can be updated later
        $discount = 0;
        
        // Apply coupon discount if exists
        if (Session::has('coupon')) {
            $discount = Session::get('coupon')['discount'];
        }
        
        // Calculate tax if needed
        $tax = 0;
        
        $total = $subtotal + $shipping + $tax - $discount;
        
        return [
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'tax' => $tax,
            'discount' => $discount,
            'total' => $total
        ];
    }

    /**
     * Get the number of items in the cart.
     */
    public function getCount()
    {
        $cart = Session::get('cart', []);
        $count = 0;
        
        foreach ($cart as $item) {
            $count += $item['quantity'];
        }
        
        return response()->json(['count' => $count]);
    }

    /**
     * Get all cart data for API.
     */
    public function getCartData()
    {
        $cart = Session::get('cart', []);
        $items = [];
        
        foreach ($cart as $id => $item) {
            $items[] = [
                'id' => $id,
                'name' => $item['name'],
                'price' => number_format($item['price'], 0, ',', '.'),
                'quantity' => $item['quantity'],
                'image' => asset($item['image'])
            ];
        }
        
        $totals = $this->calculateTotals();
        
        return response()->json([
            'items' => $items,
            'totals' => $totals
        ]);
    }

    /**
     * Remove item from cart via API.
     */
    public function apiRemoveItem($id)
    {
        $cart = Session::get('cart', []);
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false], 404);
    }

    /**
     * Fix cart images publicly accessible route
     */
    public function fixCartImages()
    {
        $this->fixCartImagePaths();
        return redirect()->route('cart.index')->with('success', 'Cart images fixed!');
    }
}
