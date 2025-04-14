<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Mail\OrderConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page.
     */
    public function index()
    {
        $cart = Session::get('cart', []);
        
        // Redirect to cart if cart is empty
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }
        
        $totals = $this->calculateTotals();
        $user = Auth::user();
        
        return view('checkout.index', compact('cart', 'totals', 'user'));
    }

    /**
     * Process the order.
     */
    public function process(Request $request)
    {
        $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_email' => 'required|email|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:255',
            'payment_method' => 'required|in:cod,bank_transfer',
            'notes' => 'nullable|string'
        ]);

        $cart = Session::get('cart', []);
        
        // Check if cart is empty
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }
        
        // Calculate totals
        $totals = $this->calculateTotals();
        
        // Create order
        $order = Order::create([
            'user_id' => Auth::id(),
            'status' => 'new',
            'total' => $totals['total'],
            'subtotal' => $totals['subtotal'],
            'tax' => $totals['tax'],
            'shipping_cost' => $totals['shipping'],
            'discount' => $totals['discount'],
            'coupon_code' => Session::has('coupon') ? Session::get('coupon')['code'] : null,
            'shipping_name' => $request->shipping_name,
            'shipping_email' => $request->shipping_email,
            'shipping_phone' => $request->shipping_phone,
            'shipping_address' => $request->shipping_address,
            'notes' => $request->notes,
            'payment_method' => $request->payment_method
        ]);
        
        // Create order items
        foreach ($cart as $item) {
            $product = Product::find($item['id']);
            
            // Skip if product not found
            if (!$product) {
                continue;
            }
            
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'subtotal' => $item['price'] * $item['quantity']
            ]);
            
            // Update product quantity
            $product->update([
                'quantity' => $product->quantity - $item['quantity']
            ]);
        }
        
        // Send order confirmation email
        Mail::to($request->shipping_email)->send(new OrderConfirmation($order));
        
        // Clear cart and coupon
        Session::forget('cart');
        Session::forget('coupon');
        
        return redirect()->route('checkout.success', $order)->with('success', 'Order placed successfully!');
    }

    /**
     * Display the order success page.
     */
    public function success(Order $order)
    {
        // Check if the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            return redirect()->route('home')->with('error', 'Unauthorized.');
        }
        
        return view('checkout.success', compact('order'));
    }

    /**
     * Calculate all cart totals.
     */
    private function calculateTotals()
    {
        $subtotal = 0;
        $cart = Session::get('cart', []);
        
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        
        $shipping = 0; // Default, can be customized
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
}
