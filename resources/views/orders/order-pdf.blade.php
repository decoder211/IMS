<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order - {{ $order->order_number }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 20px; }
        .company-name { font-size: 24px; font-weight: bold; margin-bottom: 5px; }
        .order-info { display: flex; justify-content: space-between; margin-bottom: 30px; }
        .customer-info, .order-details { width: 48%; }
        .section-title { font-weight: bold; margin-bottom: 10px; border-bottom: 1px solid #ddd; padding-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f8f9fa; font-weight: bold; }
        .total-row { background-color: #f8f9fa; font-weight: bold; }
        .footer { text-align: center; margin-top: 50px; font-size: 12px; color: #666; }
        .status-badge {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
            {{ $order->status === 'Delivered' ? 'background-color: #d1fae5; color: #065f46;' : 'background-color: #fed7aa; color: #9a3412;' }}
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">Inventory Management System</div>
        <div>Order Confirmation</div>
    </div>

    <div class="order-info">
        <div class="customer-info">
            <div class="section-title">Customer Information:</div>
            <div><strong>{{ $order->customer->name }}</strong></div>
            <div>{{ $order->customer->email }}</div>
            <div>{{ $order->customer->phone }}</div>
            <div>{{ $order->customer->address }}</div>
        </div>

        <div class="order-details">
            <div class="section-title">Order Details:</div>
            <div><strong>Order Number:</strong> {{ $order->order_number }}</div>
            <div><strong>Order Date:</strong> {{ $order->order_date->format('F d, Y') }}</div>
            <div><strong>Status:</strong> <span class="status-badge">{{ $order->status }}</span></div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Product Code</th>
                <th>Category</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $order->product->product_name }}</td>
                <td>{{ $order->product->product_code }}</td>
                <td>{{ $order->product->category->name }}</td>
                <td>{{ $order->quantity }}</td>
                <td>${{ number_format($order->unit_price, 2) }}</td>
                <td>${{ number_format($order->total_amount, 2) }}</td>
            </tr>
            <tr class="total-row">
                <td colspan="5" style="text-align: right;"><strong>Grand Total:</strong></td>
                <td><strong>${{ number_format($order->total_amount, 2) }}</strong></td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        Thank you for your order!<br>
        Inventory Management System<br>
        Generated on: {{ now()->format('F d, Y \a\t h:i A') }}
    </div>
</body>
</html>
