<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\Order;

class UserController extends Controller
{
    /**
     * Hiển thị trang thông tin tài khoản
     */
    public function account()
    {
        return view('user.account');
    }
    
    /**
     * Cập nhật thông tin tài khoản
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
        ]);
        
        $user->update($validated);
        
        return redirect()->route('user.account')->with('success', 'Thông tin tài khoản đã được cập nhật thành công!');
    }
    
    /**
     * Đổi mật khẩu
     */
    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        
        $user = Auth::user();
        
        // Kiểm tra mật khẩu hiện tại
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng']);
        }
        
        $user->update([
            'password' => Hash::make($validated['new_password']),
        ]);
        
        return redirect()->route('user.account')->with('success', 'Mật khẩu đã được thay đổi thành công!');
    }
    
    /**
     * Cập nhật avatar
     */
    public function updateAvatar(Request $request)
    {
        $user = Auth::user();
        
        // Xử lý xóa avatar
        if ($request->has('remove_avatar')) {
            // Xóa ảnh cũ nếu có
            if ($user->profile_image && !str_starts_with($user->profile_image, 'http')) {
                Storage::disk('public')->delete($user->profile_image);
            }
            
            $user->update([
                'profile_image' => null,
            ]);
            
            return redirect()->route('user.account')->with('success', 'Ảnh đại diện đã được xóa!');
        }
        
        // Xử lý tải lên avatar mới
        $request->validate([
            'profile_image' => ['required', 'image', 'max:2048'], // max 2MB
        ]);
        
        // Xóa ảnh cũ nếu có
        if ($user->profile_image && !str_starts_with($user->profile_image, 'http')) {
            Storage::disk('public')->delete($user->profile_image);
        }
        
        // Lưu ảnh mới
        $path = $request->file('profile_image')->store('avatars', 'public');
        
        $user->update([
            'profile_image' => $path,
        ]);
        
        return redirect()->route('user.account')->with('success', 'Ảnh đại diện đã được cập nhật!');
    }
    
    /**
     * Hiển thị danh sách đơn hàng
     */
    public function orders()
    {
        $orders = Auth::user()->orders()->orderBy('created_at', 'desc')->paginate(10);
        return view('user.orders', compact('orders'));
    }
    
    /**
     * Hiển thị chi tiết đơn hàng
     */
    public function orderDetail(Order $order)
    {
        // Kiểm tra xem đơn hàng có thuộc về người dùng hiện tại không
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền xem đơn hàng này');
        }
        
        return view('user.order-detail', compact('order'));
    }
    
    /**
     * Hủy đơn hàng
     */
    public function cancelOrder(Request $request)
    {
        $validated = $request->validate([
            'order_id' => ['required', 'exists:orders,id'],
            'reason' => ['required', 'string', 'max:255'],
            'other_reason' => ['nullable', 'string', 'max:500'],
        ]);
        
        $order = Order::findOrFail($validated['order_id']);
        
        // Kiểm tra xem đơn hàng có thuộc về người dùng hiện tại không
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền hủy đơn hàng này');
        }
        
        // Kiểm tra xem đơn hàng có thể hủy không
        if ($order->status !== 'Chờ xác nhận') {
            return back()->withErrors(['message' => 'Chỉ có thể hủy đơn hàng ở trạng thái chờ xác nhận']);
        }
        
        // Cập nhật trạng thái đơn hàng
        $reason = $validated['reason'];
        if ($reason === 'Khác' && !empty($validated['other_reason'])) {
            $reason = $validated['other_reason'];
        }
        
        $order->update([
            'status' => 'Đã hủy',
            'cancel_reason' => $reason,
            'canceled_at' => now(),
        ]);
        
        return redirect()->route('user.orders')->with('success', 'Đơn hàng đã được hủy thành công');
    }
} 