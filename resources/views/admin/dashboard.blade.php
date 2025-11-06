@extends('layouts.admin-layout')
@section('styles')
    <!-- Chart.js (only for dashboard) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')
    <!-- Dashboard Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
        <div class="mt-4 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-center">
                <i class="fas fa-user-circle text-blue-500 text-xl mr-3"></i>
                <span class="text-blue-800 font-semibold text-lg">Welcome back {{ Auth::user()->name ?? 'User' }}</span>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Stock Card -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg text-white overflow-hidden card-hover">
            <div class="p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Total Stock</p>
                        <p class="text-3xl font-bold mt-1">1,248</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-400 rounded-full flex items-center justify-center">
                        <i class="fas fa-boxes text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-blue-700 px-6 py-3">
                <a href="#" class="flex justify-between items-center text-white hover:text-blue-200 text-sm font-medium">
                    <span>View Details</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Sold Products Card -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg text-white overflow-hidden card-hover">
            <div class="p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-green-100 text-sm font-medium">Sold Products</p>
                        <p class="text-3xl font-bold mt-1">892</p>
                    </div>
                    <div class="w-12 h-12 bg-green-400 rounded-full flex items-center justify-center">
                        <i class="fas fa-chart-line text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-green-700 px-6 py-3">
                <a href="#" class="flex justify-between items-center text-white hover:text-green-200 text-sm font-medium">
                    <span>View Details</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Available Products Card -->
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl shadow-lg text-white overflow-hidden card-hover">
            <div class="p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-yellow-100 text-sm font-medium">Available Products</p>
                        <p class="text-3xl font-bold mt-1">356</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-400 rounded-full flex items-center justify-center">
                        <i class="fas fa-box-open text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-yellow-700 px-6 py-3">
                <a href="#" class="flex justify-between items-center text-white hover:text-yellow-200 text-sm font-medium">
                    <span>View Details</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Pending Orders Card -->
        <div class="bg-gradient-to-br from-gray-600 to-gray-700 rounded-xl shadow-lg text-white overflow-hidden card-hover">
            <div class="p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-300 text-sm font-medium">Pending Orders</p>
                        <p class="text-3xl font-bold mt-1">23</p>
                    </div>
                    <div class="w-12 h-12 bg-gray-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-clock text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-gray-800 px-6 py-3">
                <a href="#" class="flex justify-between items-center text-white hover:text-gray-300 text-sm font-medium">
                    <span>View Details</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Bar Chart -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-800">Statistical overview Bar Chart (Sample)</h3>
                <i class="fas fa-chart-bar text-gray-500 text-xl"></i>
            </div>
            <div class="h-80">
                <canvas id="barChart"></canvas>
            </div>
        </div>

        <!-- Area Chart -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-800">Statistical overview Area Chart (Sample)</h3>
                <i class="fas fa-chart-area text-gray-500 text-xl"></i>
            </div>
            <div class="h-80">
                <canvas id="areaChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Overview</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="text-center p-4 bg-blue-50 rounded-lg">
                <p class="text-2xl font-bold text-blue-600">12</p>
                <p class="text-sm text-gray-600">Low Stock Items</p>
            </div>
            <div class="text-center p-4 bg-green-50 rounded-lg">
                <p class="text-2xl font-bold text-green-600">45</p>
                <p class="text-sm text-gray-600">This Month Sales</p>
            </div>
            <div class="text-center p-4 bg-yellow-50 rounded-lg">
                <p class="text-2xl font-bold text-yellow-600">8</p>
                <p class="text-sm text-gray-600">New Customers</p>
            </div>
            <div class="text-center p-4 bg-purple-50 rounded-lg">
                <p class="text-2xl font-bold text-purple-600">92%</p>
                <p class="text-sm text-gray-600">Order Accuracy</p>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Initialize Charts when page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Bar Chart
            const barCtx = document.getElementById('barChart').getContext('2d');
            new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Sales',
                        data: [65, 59, 80, 81, 56, 55],
                        backgroundColor: 'rgba(59, 130, 246, 0.8)',
                        borderColor: 'rgb(59, 130, 246)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Area Chart
            const areaCtx = document.getElementById('areaChart').getContext('2d');
            new Chart(areaCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Inventory Value',
                        data: [30, 45, 35, 50, 40, 60],
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        borderColor: 'rgb(16, 185, 129)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endsection
