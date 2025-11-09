@extends('layouts.app')

@section('title', 'Create Sale Invoice')

@section('content')
<div class="flex justify-center items-start min-h-screen py-8">
    <div class="w-full max-w-4xl">
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
                <div class="mb-4 sm:mb-0">
                    <h1 class="text-3xl font-bold text-gray-800">Create Sale Invoice</h1>
                    <p class="text-gray-600 mt-2">Generate a new sales invoice</p>
                </div>
                <a href="{{ route('sales.index') }}" class="inline-flex items-center bg-gray-600 hover:bg-gray-700 text-white px-5 py-3 rounded-lg font-medium transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Invoices
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <form action="{{ route('sales.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Customer Selection -->
                    <div class="md:col-span-2">
                        <label for="customer_id" class="block text-sm font-medium text-gray-700 mb-2">Customer *</label>
                        <select name="customer_id" id="customer_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                required>
                            <option value="">Select Customer</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }} - {{ $customer->email }}
                                </option>
                            @endforeach
                        </select>
                        @error('customer_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Product Selection -->
                    <div class="md:col-span-2">
                        <label for="product_id" class="block text-sm font-medium text-gray-700 mb-2">Product *</label>
                        <select name="product_id" id="product_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                required>
                            <option value="">Select Product</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }} data-stock="{{ $product->stock }}" data-price="{{ $product->sale_price }}">
                                    {{ $product->product_name }} ({{ $product->product_code }}) - Stock: {{ $product->stock }} - ${{ number_format($product->sale_price, 2) }}
                                </option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Product Details -->
                    <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-gray-50 rounded-lg" id="productDetails" style="display: none;">
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Available Stock</label>
                            <div class="text-sm font-medium text-gray-900" id="productStock"></div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Unit Price</label>
                            <div class="text-sm font-medium text-green-600" id="productPrice"></div>
                        </div>
                    </div>

                    <!-- Quantity -->
                    <div>
                        <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Quantity *</label>
                        <input type="number" name="quantity" id="quantity" value="{{ old('quantity', 1) }}" min="1"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                               required>
                        @error('quantity')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Payment Status -->
                    <div>
                        <label for="payment_status" class="block text-sm font-medium text-gray-700 mb-2">Payment Status *</label>
                        <select name="payment_status" id="payment_status"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                required>
                            <option value="Pending" {{ old('payment_status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Done" {{ old('payment_status') == 'Done' ? 'selected' : '' }}>Paid</option>
                        </select>
                        @error('payment_status')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Invoice Date -->
                    <div class="md:col-span-2">
                        <label for="invoice_date" class="block text-sm font-medium text-gray-700 mb-2">Invoice Date *</label>
                        <input type="date" name="invoice_date" id="invoice_date" value="{{ old('invoice_date', date('Y-m-d')) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                               required>
                        @error('invoice_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Total Amount Preview -->
                    <div class="md:col-span-2 p-4 bg-blue-50 rounded-lg">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-700">Total Amount:</span>
                            <span class="text-lg font-bold text-blue-600" id="totalAmount">$0.00</span>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('sales.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-medium transition-colors text-center">
                        Cancel
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors flex items-center justify-center">
                        <i class="fas fa-file-invoice mr-2"></i>Create Invoice
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const productSelect = document.getElementById('product_id');
        const quantityInput = document.getElementById('quantity');
        const productDetails = document.getElementById('productDetails');
        const totalAmount = document.getElementById('totalAmount');

        // Product selection handler
        productSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value) {
                document.getElementById('productStock').textContent = selectedOption.dataset.stock + ' units';
                document.getElementById('productPrice').textContent = '$' + parseFloat(selectedOption.dataset.price).toFixed(2);
                productDetails.style.display = 'grid';
                calculateTotal();
            } else {
                productDetails.style.display = 'none';
                totalAmount.textContent = '$0.00';
            }
        });

        // Quantity change handler
        quantityInput.addEventListener('input', calculateTotal);

        function calculateTotal() {
            const selectedProduct = productSelect.options[productSelect.selectedIndex];
            const quantity = parseInt(quantityInput.value) || 0;

            if (selectedProduct && selectedProduct.value) {
                const price = parseFloat(selectedProduct.dataset.price);
                const total = price * quantity;
                totalAmount.textContent = '$' + total.toFixed(2);
            }
        }

        // Trigger change event on page load if value is preselected
        if (productSelect.value) productSelect.dispatchEvent(new Event('change'));
    });
</script>
@endsection
@endsection
