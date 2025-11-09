@extends('layouts.app')

@section('title', 'Sales Invoices')

@section('content')
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-3xl font-bold text-gray-800">Sales Invoices</h1>
            <p class="text-gray-600 mt-2">Manage sales and invoices</p>
        </div>
        <a href="{{ route('sales.create') }}" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg font-medium transition-colors">
            <i class="fas fa-plus mr-2"></i>New Invoice
        </a>
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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice #</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($sales as $sale)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-mono font-medium text-gray-900">{{ $sale->invoice_number }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $sale->customer->name }}</div>
                        <div class="text-sm text-gray-500">{{ $sale->customer->email }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $sale->product->product_name }}</div>
                        <div class="text-sm text-gray-500">{{ $sale->product->product_code }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $sale->quantity }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-green-600">${{ number_format($sale->total, 2) }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $sale->invoice_date->format('M d, Y') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $sale->payment_status === 'Done' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $sale->payment_status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-3">
                            <a href="{{ route('sales.download-invoice', $sale) }}" class="text-blue-600 hover:text-blue-900 transition-colors flex items-center">
                                <i class="fas fa-download mr-1"></i> Invoice
                            </a>
                          <button onclick="togglePayment({{ $sale->id }})"
        class="{{ $sale->payment_status === 'Done' ? 'bg-orange-100 text-orange-800 hover:bg-orange-200' : 'bg-green-100 text-green-800 hover:bg-green-200' }} px-3 py-1 rounded-full text-xs font-medium transition-colors flex items-center">
    @if($sale->payment_status === 'Done')
    <i class="fas fa-clock mr-1"></i> Mark Pending
    @else
    <i class="fas fa-check mr-1"></i> Mark Paid
    @endif
</button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-8 text-center">
                        <div class="text-gray-500 mb-2">
                            <i class="fas fa-receipt text-4xl mb-3"></i>
                        </div>
                        <p class="text-sm text-gray-500 mb-2">No sales invoices found.</p>
                        <a href="{{ route('sales.create') }}" class="text-blue-600 hover:text-blue-900 font-medium">Create the first invoice</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($sales->hasPages())
    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
        {{ $sales->links() }}
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
function togglePayment(saleId) {
    fetch(`/sales/${saleId}/toggle-payment`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Reload the page to see the updated status
                window.location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error updating payment status');
        });
}
</script>
@endsection
