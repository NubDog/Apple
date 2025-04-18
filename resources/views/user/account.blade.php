@extends('layouts.app')

@section('content')
<div class="container py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h1 class="text-2xl font-semibold mb-6">Tài khoản của tôi</h1>
                
                <div class="mb-6">
                    <h2 class="text-xl font-medium mb-2">Thông tin cá nhân</h2>
                    <p><strong>Tên:</strong> {{ $user->name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                </div>

                <div class="mb-6">
                    <h2 class="text-xl font-medium mb-2">Đơn hàng gần đây</h2>
                    @if($recentOrders->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full border">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2 border">Mã đơn hàng</th>
                                        <th class="px-4 py-2 border">Ngày</th>
                                        <th class="px-4 py-2 border">Trạng thái</th>
                                        <th class="px-4 py-2 border">Tổng tiền</th>
                                        <th class="px-4 py-2 border">Chi tiết</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentOrders as $order)
                                    <tr>
                                        <td class="px-4 py-2 border">{{ $order->id }}</td>
                                        <td class="px-4 py-2 border">{{ $order->created_at->format('d/m/Y') }}</td>
                                        <td class="px-4 py-2 border">{{ $order->status }}</td>
                                        <td class="px-4 py-2 border">{{ number_format($order->total, 0, ',', '.') }}đ</td>
                                        <td class="px-4 py-2 border">
                                            <a href="{{ route('user.order.detail', $order->id) }}" class="text-blue-600 hover:underline">Xem</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('user.orders') }}" class="text-blue-600 hover:underline">Xem tất cả đơn hàng</a>
                        </div>
                    @else
                        <p>Bạn chưa có đơn hàng nào.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 