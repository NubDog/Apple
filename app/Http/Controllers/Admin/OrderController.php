<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\OrderStatusUpdate;
use App\Models\Order;
use Illuminate\Http\Request;
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
     * No destroy method implementation as orders should not be deleted.
     */
    public function destroy(string $id)
    {
        return redirect()->route('admin.orders.index')
            ->with('error', 'Orders cannot be deleted');
    }
}
