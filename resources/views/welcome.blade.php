<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Inventory Management System</title>

        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <style>
            @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');
        </style>
    </head>
    <body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 font-sans min-h-screen flex flex-col">
        <!-- Header -->
        <header class="w-full py-4 px-6 lg:px-8">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-boxes text-white text-sm"></i>
                    </div>
                    <span class="text-xl font-semibold">Inventory Management</span>
                </div>

                {{-- <nav class="hidden md:flex items-center space-x-6">
                    <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 transition-colors">Features</a>
                    <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 transition-colors">Pricing</a>
                    <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 transition-colors">About</a>
                </nav> --}}

                <div class="flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 transition-colors">
                                Log in
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                                    Register
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">
                        Streamline Your
                        <span class="text-blue-600">Inventory</span>
                    </h1>
                    <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto mb-10">
                        Take control of your stock with our  inventory management system. Track products, manage suppliers, and optimize your operations.
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-medium transition-colors text-lg">
                                Go to Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-medium transition-colors text-lg">
                                Go to DASHBOARD
                            </a>
                            {{-- <a href="{{ route('login') }}" class="border border-gray-300 dark:border-gray-700 hover:border-blue-500 text-gray-700 dark:text-gray-300 px-8 py-3 rounded-lg font-medium transition-colors text-lg">
                                Sign In
                            </a> --}}
                        @endauth
                    </div>
                </div>

                <!-- Features Section -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-16">
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mb-4">
                            <i class="fas fa-boxes text-blue-600 text-xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Product Management</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Easily add, edit, and organize your products with detailed information and categorization.
                        </p>
                    </div>

                    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md">
                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center mb-4">
                            <i class="fas fa-chart-line text-green-600 text-xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Stock Tracking</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Monitor inventory levels in real-time , alerts for low stock or overstock situations.
                        </p>
                    </div>

                    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md">
                        <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center mb-4">
                            <i class="fas fa-file-invoice-dollar text-purple-600 text-xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Reporting</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Generate detailed reports on sales, inventory turnover, and product performance.
                        </p>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 py-8 px-6 lg:px-8 mt-16">
            <div class="max-w-7xl mx-auto">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="flex items-center space-x-2 mb-4 md:mb-0">
                        <div class="w-6 h-6 bg-blue-600 rounded flex items-center justify-center">
                            <i class="fas fa-boxes text-white text-xs"></i>
                        </div>
                        <span class="font-semibold">Inventory Management</span>
                    </div>
                    <div class="text-gray-500 dark:text-gray-400 text-sm">
                        &copy; 2023 Inventory Management System.
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>
