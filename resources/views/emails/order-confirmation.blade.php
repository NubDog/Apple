<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Xác nhận đơn hàng #{{ $order->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 1px solid #eee;
        }
        .order-info {
            margin: 20px 0;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .order-details {
            margin-top: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        th {
            background-color: #f8f9fa;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #777;
            font-size: 12px;
        }
        .total-row {
            font-weight: bold;
        }
        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            background-color: #e3f2fd;
            color: #0d47a1;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Cảm ơn bạn đã đặt hàng!</h1>
            <p>Đơn hàng #{{ $order->id }} của bạn đã được xác nhận</p>
        </div>
        
        <p>Xin chào {{ $order->shipping_name }},</p>
        
        <p>Chúng tôi rất vui thông báo rằng đơn hàng của bạn đã được xác nhận và đang được xử lý.</p>
        
        <div class="order-info">
            <h3>Thông tin đơn hàng</h3>
            <p><strong>Mã đơn hàng:</strong> #{{ $order->id }}</p>
            <p><strong>Ngày đặt hàng:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Trạng thái:</strong> <span class="status">{{ ucfirst($order->status) }}</span></p>
            <p><strong>Phương thức thanh toán:</strong> 
                @switch($order->payment_method)
                    @case('cod')
                        Thanh toán khi nhận hàng (COD)
                        @break
                    @case('bank_transfer')
                        Chuyển khoản ngân hàng
                        @break
                    @case('momo')
                        Ví MoMo
                        @break
                    @case('zalopay')
                        Ví ZaloPay
                        @break
                    @case('vnpay')
                        VNPAY-QR
                        @break
                    @case('credit_card')
                        Thẻ tín dụng / Ghi nợ
                        @break
                    @default
                        {{ $order->payment_method }}
                @endswitch
            </p>
        </div>
        
        <div class="order-info">
            <h3>Thông tin giao hàng</h3>
            <p><strong>Người nhận:</strong> {{ $order->shipping_name }}</p>
            <p><strong>Email:</strong> {{ $order->shipping_email }}</p>
            <p><strong>Số điện thoại:</strong> {{ $order->shipping_phone }}</p>
            <p><strong>Địa chỉ:</strong> {{ $order->shipping_address }}</p>
            <p><strong>Phương thức vận chuyển:</strong> 
                @switch($order->shipping_method)
                    @case('viettel_post')
                        Viettel Post
                        @break
                    @case('shopee_express')
                        Shopee Express
                        @break
                    @case('self_transport')
                        Giao hàng hỏa tốc
                        @break
                    @case('self_pickup')
                        Nhận tại cửa hàng
                        @break
                    @default
                        {{ $order->shipping_method }}
                @endswitch
            </p>
        </div>
        
        <div class="order-details">
            <h3>Chi tiết đơn hàng</h3>
            <table>
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->price, 0, ',', '.') }}₫</td>
                        <td>{{ number_format($item->subtotal, 0, ',', '.') }}₫</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="3" align="right">Tạm tính:</td>
                        <td>{{ number_format($order->subtotal, 0, ',', '.') }}₫</td>
                    </tr>
                    @if($order->shipping_cost > 0)
                    <tr>
                        <td colspan="3" align="right">Phí vận chuyển:</td>
                        <td>{{ number_format($order->shipping_cost, 0, ',', '.') }}₫</td>
                    </tr>
                    @endif
                    @if($order->tax > 0)
                    <tr>
                        <td colspan="3" align="right">Thuế:</td>
                        <td>{{ number_format($order->tax, 0, ',', '.') }}₫</td>
                    </tr>
                    @endif
                    @if($order->discount > 0)
                    <tr>
                        <td colspan="3" align="right">Giảm giá:</td>
                        <td>-{{ number_format($order->discount, 0, ',', '.') }}₫</td>
                    </tr>
                    @endif
                    <tr class="total-row">
                        <td colspan="3" align="right">Tổng cộng:</td>
                        <td>{{ number_format($order->total, 0, ',', '.') }}₫</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <p>Chúng tôi sẽ thông báo cho bạn khi đơn hàng được giao.</p>
        <p>Nếu bạn có bất kỳ câu hỏi nào về đơn hàng, vui lòng liên hệ với chúng tôi qua email hoặc số điện thoại.</p>
        
        <p>Trân trọng,<br>Đội ngũ Apple Store</p>
        
        <div class="footer">
            <p>© {{ date('Y') }} Apple Store. Tất cả các quyền được bảo lưu.</p>
        </div>
    </div>
</body>
</html> 