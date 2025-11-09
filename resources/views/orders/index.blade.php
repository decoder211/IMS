@extends('layouts.app')

@section('title', 'All Orders')

@section('content')
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-3xl font-bold text-gray-800">All Orders</h1>
            <p class="text-gray-600 mt-2">Manage customer orders</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('orders.pending') }}" class="inline-flex items-center bg-orange-600 hover:bg-orange-700 text-white px-5 py-3 rounded-lg font-medium transition-colors">
                <i class="fas fa-clock mr-2"></i>Pending Orders
            </a>
            <a href="{{ route('orders.create') }}" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg font-medium transition-colors">
                <i class="fas fa-plus mr-2"></i>New Order
            </a>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order #</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($orders as $order)
                <tr class="hover:bg-gray-50 transition-colors">
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
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $order->status === 'Delivered' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' }}">
                            {{ $order->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-3">
                            @if($order->status === 'Pending')
                            <form action="{{ route('orders.update-status', $order) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="Delivered">
                                <button type="submit" class="text-green-600 hover:text-green-900 transition-colors flex items-center" title="Mark as Delivered">
                                    <i class="fas fa-check mr-1"></i> Deliver
                                </button>
                            </form>
                            @endif
                            <a href="{{ route('orders.download-order', $order) }}" class="text-blue-600 hover:text-blue-900 transition-colors flex items-center">
                                <i class="fas fa-download mr-1"></i> PDF
                            </a>
                            <form action="{{ route('orders.destroy', $order) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this order?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 transition-colors flex items-center">
                                    <i class="fas fa-trash mr-1"></i> Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-8 text-center">
                        <div class="text-gray-500 mb-2">
                            <i class="fas fa-shopping-cart text-4xl mb-3"></i>
                        </div>
                        <p class="text-sm text-gray-500 mb-2">No orders found.</p>
                        <a href="{{ route('orders.create') }}" class="text-blue-600 hover:text-blue-900 font-medium">Create the first order</a>
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
