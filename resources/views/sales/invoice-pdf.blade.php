<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice - {{ $sale->invoice_number }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 20px; }
        .company-name { font-size: 24px; font-weight: bold; margin-bottom: 5px; }
        .invoice-info { display: flex; justify-content: space-between; margin-bottom: 30px; }
        .customer-info, .invoice-details { width: 48%; }
        .section-title { font-weight: bold; margin-bottom: 10px; border-bottom: 1px solid #ddd; padding-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f8f9fa; font-weight: bold; }
        .total-row { background-color: #f8f9fa; font-weight: bold; }
        .footer { text-align: center; margin-top: 50px; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">Inventory Management System</div>
        <div>Sales Invoice</div>
    </div>

    <div class="invoice-info">
        <div class="customer-info">
            <div class="section-title">Bill To:</div>
            <div><strong>{{ $sale->customer->name }}</strong></div>
            <div>{{ $sale->customer->email }}</div>
            <div>{{ $sale->customer->phone }}</div>
            <div>{{ $sale->customer->address }}</div>
        </div>

        <div class="invoice-details">
            <div class="section-title">Invoice Details:</div>
            <div><strong>Invoice Number:</strong> {{ $sale->invoice_number }}</div>
            <div><strong>Invoice Date:</strong> {{ $sale->invoice_date->format('F d, Y') }}</div>
            <div><strong>Payment Status:</strong> {{ $sale->payment_status }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Product Code</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $sale->product->product_name }}</td>
                <td>{{ $sale->product->product_code }}</td>
                <td>{{ $sale->quantity }}</td>
                <td>${{ number_format($sale->price, 2) }}</td>
                <td>${{ number_format($sale->total, 2) }}</td>
            </tr>
            <tr class="total-row">
                <td colspan="4" style="text-align: right;"><strong>Grand Total:</strong></td>
                <td><strong>${{ number_format($sale->total, 2) }}</strong></td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        Thank you for your business!<br>
        Inventory Management System<br>
        Generated on: {{ now()->format('F d, Y \a\t h:i A') }}
    </div>
</body>
</html>
