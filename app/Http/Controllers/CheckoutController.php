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
            'shipping_method' => 'required|string|in:viettel_post,shopee_express,self_pickup,self_transport',
            'payment_method' => 'required|in:cod,bank_transfer,momo,zalopay,vnpay,credit_card',
            'notes' => 'nullable|string'
        ]);

        $cart = Session::get('cart', []);
        
        // Check if cart is empty
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }
        
        // Calculate totals
        $totals = $this->calculateTotals();
        
        // Set shipping cost based on selected method
        $shippingCost = 0;
        switch ($request->shipping_method) {
            case 'viettel_post':
                $shippingCost = 30000;
                break;
            case 'shopee_express':
                $shippingCost = 25000;
                break;
            case 'self_transport':
                $shippingCost = 40000;
                break;
            case 'self_pickup':
                $shippingCost = 0;
                break;
            default:
                $shippingCost = 0;
        }
        
        // Update total with shipping cost
        $totals['shipping'] = $shippingCost;
        $totals['total'] = $totals['subtotal'] + $shippingCost + $totals['tax'] - $totals['discount'];
        
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
            'shipping_method' => $request->shipping_method,
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
        // Add convenience properties for the view
        $order->payment_method_text = $this->getPaymentMethodText($order->payment_method);
        $order->shipping_method_text = $this->getShippingMethodText($order->shipping_method);
        
        return view('checkout.success', compact('order'));
    }

    /**
     * Get human-readable payment method.
     */
    private function getPaymentMethodText($method)
    {
        switch ($method) {
            case 'cod':
                return 'Thanh toán khi nhận hàng (COD)';
            case 'momo':
                return 'Ví MoMo';
            case 'zalopay':
                return 'Ví ZaloPay';
            case 'vnpay':
                return 'VNPAY-QR';
            case 'bank_transfer':
                return 'Chuyển khoản ngân hàng';
            case 'credit_card':
                return 'Thẻ tín dụng / Ghi nợ';
            default:
                return $method;
        }
    }

    /**
     * Get human-readable shipping method.
     */
    private function getShippingMethodText($method)
    {
        switch ($method) {
            case 'viettel_post':
                return 'Viettel Post';
            case 'shopee_express':
                return 'Shopee Express';
            case 'self_transport':
                return 'Giao hàng hỏa tốc';
            case 'self_pickup':
                return 'Nhận tại cửa hàng';
            default:
                return $method;
        }
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
