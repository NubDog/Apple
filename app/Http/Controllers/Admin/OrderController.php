<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\OrderStatusUpdate;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Display a listing of all orders.
     */
    public function index()
    {
        $orders = Order::with('user')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display orders by status.
     */
    public function ordersByStatus($status)
    {
        $validStatuses = ['new', 'processing', 'shipped', 'delivered', 'cancelled'];
        
        if (!in_array($status, $validStatuses)) {
            return redirect()->route('admin.orders.index')->with('error', 'Invalid status');
        }
        
        $orders = Order::with('user')
            ->where('status', $status)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.orders.status', compact('orders', 'status'));
    }

    /**
     * Show the form for creating a new order.
     */
    public function create()
    {
        $users = User::where('role', 'user')->orderBy('name')->get();
        $products = Product::where('quantity', '>', 0)->orderBy('name')->get();
        return view('admin.orders.create', compact('users', 'products'));
    }

    /**
     * Store a newly created order in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'shipping_name' => 'required|string|max:255',
            'shipping_email' => 'required|email|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:255',
            'status' => 'required|in:new,processing,shipped,delivered,cancelled',
            'payment_method' => 'required|in:cod,bank_transfer',
            'notes' => 'nullable|string',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1'
        ]);

        // Calculate subtotal and process order items
        $subtotal = 0;
        $orderItems = [];
        $tax = 0;
        $shipping_cost = $request->input('shipping_cost', 0);
        $discount = $request->input('discount', 0);

        foreach ($request->products as $productData) {
            $product = Product::findOrFail($productData['id']);
            
            // Check if quantity is available
            if ($product->quantity < $productData['quantity']) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', "Insufficient stock for product: {$product->name}");
            }
            
            $price = $product->on_sale && $product->sale_price ? $product->sale_price : $product->price;
            $itemSubtotal = $price * $productData['quantity'];
            $subtotal += $itemSubtotal;
            
            $orderItems[] = [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'price' => $price,
                'quantity' => $productData['quantity'],
                'subtotal' => $itemSubtotal
            ];
            
            // Reduce product quantity
            $product->update([
                'quantity' => $product->quantity - $productData['quantity']
            ]);
        }
        
        // Calculate total
        $total = $subtotal + $tax + $shipping_cost - $discount;
        
        // Create order
        $order = Order::create([
            'user_id' => $request->user_id,
            'status' => $request->status,
            'total' => $total,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'shipping_cost' => $shipping_cost,
            'discount' => $discount,
            'coupon_code' => $request->coupon_code,
            'shipping_name' => $request->shipping_name,
            'shipping_email' => $request->shipping_email,
            'shipping_phone' => $request->shipping_phone,
            'shipping_address' => $request->shipping_address,
            'notes' => $request->notes,
            'payment_method' => $request->payment_method
        ]);
        
        // Create order items
        foreach ($orderItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'product_name' => $item['product_name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'subtotal' => $item['subtotal']
            ]);
        }
        
        // Send email notification
        Mail::to($order->shipping_email)->send(new OrderStatusUpdate($order));
        
        return redirect()->route('admin.orders.show', $order->id)
            ->with('success', 'Order created successfully');
    }

    /**
     * Display the specified order.
     */
    public function show(string $id)
    {
        $order = Order::with(['items.product', 'user'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified order.
     */
    public function edit(string $id)
    {
        $order = Order::with(['items.product', 'user'])->findOrFail($id);
        return view('admin.orders.edit', compact('order'));
    }

    /**
     * Update the specified order in storage.
     */
    public function update(Request $request, string $id)
    {
        $order = Order::findOrFail($id);
        
        $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_email' => 'required|email|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:255',
            'status' => 'required|in:new,processing,shipped,delivered,cancelled',
            'payment_method' => 'required|in:cod,bank_transfer',
            'notes' => 'nullable|string'
        ]);
        
        $oldStatus = $order->status;
        $newStatus = $request->status;
        
        $order->update($request->all());
        
        // Send email notification if status changed
        if ($oldStatus !== $newStatus) {
            Mail::to($order->shipping_email)->send(new OrderStatusUpdate($order));
        }
        
        return redirect()->route('admin.orders.index')
            ->with('success', 'Order updated successfully');
    }

    /**
     * Update only the status of an order.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:new,processing,shipped,delivered,cancelled'
        ]);
        
        $oldStatus = $order->status;
        $newStatus = $request->status;
        
        $order->update([
            'status' => $newStatus
        ]);
        
        // Send email notification if status changed
        if ($oldStatus !== $newStatus) {
            Mail::to($order->shipping_email)->send(new OrderStatusUpdate($order));
        }
        
        return redirect()->back()->with('success', 'Order status updated successfully');
    }

    /**
     * Remove the specified order from storage with confirmation.
     */
    public function destroy(string $id)
    {
        $order = Order::with('items')->findOrFail($id);
        
        // If the order is delivered, don't allow deletion
        if ($order->status === 'delivered') {
            return redirect()->route('admin.orders.index')
                ->with('error', 'Delivered orders cannot be deleted');
        }
        
        // For any other status, restore the product quantities
        if ($order->status !== 'delivered') {
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->update([
                        'quantity' => $item->product->quantity + $item->quantity
                    ]);
                }
            }
        }
        
        // Delete related order items
        $order->items()->delete();
        
        // Delete the order
        $order->delete();
        
        return redirect()->route('admin.orders.index')
            ->with('success', 'Order deleted successfully');
    }
}
