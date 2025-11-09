@extends('layouts.app')

@section('title', 'Delivered Orders')

@section('content')
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-3xl font-bold text-gray-800">Delivered Orders</h1>
            <p class="text-gray-600 mt-2">Completed and delivered orders</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('orders.index') }}" class="inline-flex items-center bg-gray-600 hover:bg-gray-700 text-white px-5 py-3 rounded-lg font-medium transition-colors">
                <i class="fas fa-list mr-2"></i>All Orders
            </a>
            <a href="{{ route('orders.pending') }}" class="inline-flex items-center bg-orange-600 hover:bg-orange-700 text-white px-5 py-3 rounded-lg font-medium transition-colors">
                <i class="fas fa-clock mr-2"></i>Pending Orders
            </a>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-green-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-green-600 uppercase tracking-wider">Order #</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-green-600 uppercase tracking-wider">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-green-600 uppercase tracking-wider">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-green-600 uppercase tracking-wider">Quantity</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-green-600 uppercase tracking-wider">Total Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-green-600 uppercase tracking-wider">Order Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-green-600 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($orders as $order)
                <tr class="hover:bg-green-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-mono font-medium text-gray-900">{{ $order->order_number }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $order->customer->name }}</div>
                        <div class="text-sm text-gray-500">{{ $order->customer->email }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $order->product->product_name }}</div>
                        <div class="text-sm text-gray-500">{{ $order->product->product_code }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $order->quantity }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-green-600">${{ number_format($order->total_amount, 2) }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $order->order_date->format('M d, Y') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('orders.download-order', $order) }}" class="text-blue-600 hover:text-blue-900 transition-colors flex items-center">
                            <i class="fas fa-download mr-1"></i> Download PDF
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center">
                        <div class="text-gray-500 mb-2">
                            <i class="fas fa-truck text-4xl mb-3"></i>
                        </div>
                        <p class="text-sm text-gray-500 mb-2">No delivered orders found.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($orders->hasPages())
    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
        {{ $orders->links() }}
    </div>
    @endif
</div>
@endsection
