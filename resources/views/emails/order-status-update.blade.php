<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cập nhật trạng thái đơn hàng #{{ $order->id }}</title>
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
        .status-highlight {
            background-color: #e8f5e9;
            border-left: 4px solid #43a047;
            padding: 15px;
            margin: 20px 0;
        }
        .order-summary {
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
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #777;
            font-size: 12px;
        }
        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-new {
            background-color: #e3f2fd;
            color: #0d47a1;
        }
        .status-processing {
            background-color: #fff8e1;
            color: #ff8f00;
        }
        .status-shipped {
            background-color: #e8f5e9;
            color: #2e7d32;
        }
        .status-delivered {
            background-color: #e0f2f1;
            color: #00796b;
        }
        .status-cancelled {
            background-color: #ffebee;
            color: #c62828;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Cập nhật trạng thái đơn hàng</h1>
        </div>
        
        <p>Xin chào {{ $order->shipping_name }},</p>
        
        <div class="status-highlight">
            <h3>Trạng thái đơn hàng của bạn đã được cập nhật</h3>
            <p>Đơn hàng #{{ $order->id }} hiện đang ở trạng thái:
                <span class="status status-{{ $order->status }}">
                @switch($order->status)
                    @case('new')
                        Đơn hàng mới
                        @break
                    @case('processing')
                        Đang xử lý
                        @break
                    @case('shipped')
                        Đã giao cho đơn vị vận chuyển
                        @break
                    @case('delivered')
                        Đã giao hàng
                        @break
                    @case('cancelled')
                        Đã hủy
                        @break
                    @default
                        {{ ucfirst($order->status) }}
                @endswitch
                </span>
            </p>
            
            @if($order->status == 'new')
                <p>Đơn hàng của bạn đã được tạo thành công và đang chờ xử lý.</p>
            @elseif($order->status == 'processing')
                <p>Đơn hàng của bạn đang được xử lý. Chúng tôi sẽ sớm chuẩn bị và đóng gói hàng cho bạn.</p>
            @elseif($order->status == 'shipped')
                <p>Đơn hàng của bạn đã được giao cho đơn vị vận chuyển và đang trên đường đến bạn.</p>
                <p>Hãy chuẩn bị sẵn sàng để nhận hàng trong vài ngày tới.</p>
            @elseif($order->status == 'delivered')
                <p>Đơn hàng của bạn đã được giao thành công.</p>
                <p>Cảm ơn bạn đã mua sắm tại Apple Store! Chúng tôi hy vọng bạn hài lòng với sản phẩm.</p>
            @elseif($order->status == 'cancelled')
                <p>Đơn hàng của bạn đã bị hủy.</p>
                <p>Nếu bạn đã thanh toán, số tiền sẽ được hoàn lại cho bạn trong 3-5 ngày làm việc.</p>
            @endif
        </div>
        
        <div class="order-info">
            <h3>Thông tin đơn hàng</h3>
            <p><strong>Mã đơn hàng:</strong> #{{ $order->id }}</p>
            <p><strong>Ngày đặt hàng:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
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
            <p><strong>Tổng tiền:</strong> {{ number_format($order->total, 0, ',', '.') }}₫</p>
        </div>
        
        <div class="order-info">
            <h3>Thông tin giao hàng</h3>
            <p><strong>Người nhận:</strong> {{ $order->shipping_name }}</p>
            <p><strong>Địa chỉ:</strong> {{ $order->shipping_address }}</p>
            <p><strong>Số điện thoại:</strong> {{ $order->shipping_phone }}</p>
        </div>
        
        <div class="order-summary">
            <h3>Tóm tắt đơn hàng</h3>
            <table>
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->subtotal, 0, ',', '.') }}₫</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <p>Nếu bạn có bất kỳ câu hỏi nào về đơn hàng, vui lòng liên hệ với chúng tôi qua email hoặc số điện thoại hỗ trợ.</p>
        
        <p>Trân trọng,<br>Đội ngũ Apple Store</p>
        
        <div class="footer">
            <p>© {{ date('Y') }} Apple Store. Tất cả các quyền được bảo lưu.</p>
        </div>
    </div>
</body>
</html> 