@extends('layouts.app')

@section('content')
<div class="container py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h1 class="text-2xl font-semibold mb-6">Chi tiết đơn hàng #{{ $order->id }}</h1>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h2 class="text-xl font-medium mb-2">Thông tin đơn hàng</h2>
                        <p><strong>Ngày đặt hàng:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                        <p><strong>Trạng thái:</strong> {{ $order->status }}</p>
                        <p><strong>Phương thức thanh toán:</strong> {{ $order->payment_method }}</p>
                    </div>
                    
                    <div>
                        <h2 class="text-xl font-medium mb-2">Địa chỉ giao hàng</h2>
                        <p><strong>Người nhận:</strong> {{ $order->shipping_name }}</p>
                        <p><strong>Địa chỉ:</strong> {{ $order->shipping_address }}</p>
                        <p><strong>Điện thoại:</strong> {{ $order->shipping_phone }}</p>
                        <p><strong>Email:</strong> {{ $order->shipping_email }}</p>
                    </div>
                </div>
                
                <h2 class="text-xl font-medium mb-2">Sản phẩm</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full border">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border">Sản phẩm</th>
                                <th class="px-4 py-2 border">Đơn giá</th>
                                <th class="px-4 py-2 border">Số lượng</th>
                                <th class="px-4 py-2 border">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td class="px-4 py-2 border">
                                    {{ $item->product->name }}
                                </td>
                                <td class="px-4 py-2 border">{{ number_format($item->price, 0, ',', '.') }}đ</td>
                                <td class="px-4 py-2 border">{{ $item->quantity }}</td>
                                <td class="px-4 py-2 border">{{ number_format($item->price * $item->quantity, 0, ',', '.') }}đ</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="px-4 py-2 border text-right"><strong>Tổng phụ:</strong></td>
                                <td class="px-4 py-2 border">{{ number_format($order->subtotal, 0, ',', '.') }}đ</td>
                            </tr>
                            @if($order->discount > 0)
                            <tr>
                                <td colspan="3" class="px-4 py-2 border text-right"><strong>Giảm giá:</strong></td>
                                <td class="px-4 py-2 border">-{{ number_format($order->discount, 0, ',', '.') }}đ</td>
                            </tr>
                            @endif
                            <tr>
                                <td colspan="3" class="px-4 py-2 border text-right"><strong>Phí vận chuyển:</strong></td>
                                <td class="px-4 py-2 border">{{ number_format($order->shipping_fee, 0, ',', '.') }}đ</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="px-4 py-2 border text-right"><strong>Tổng cộng:</strong></td>
                                <td class="px-4 py-2 border font-bold">{{ number_format($order->total, 0, ',', '.') }}đ</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <div class="mt-6">
                    <a href="{{ route('user.orders') }}" class="text-blue-600 hover:underline">← Quay lại danh sách đơn hàng</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 