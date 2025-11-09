<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Inventory Management System') }} - Admin</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @yield('styles')

    <style>
        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            overflow-x: hidden;
        }

        .card-hover:hover {
            transform: translateY(-2px);
            transition: all 0.3s ease;
        }

        .sidebar-transition {
            transition: all 0.3s ease-in-out;
        }

        .submenu-transition {
            transition: all 0.3s ease-in-out;
            overflow: hidden;
        }

        .rotate-180 {
            transform: rotate(180deg);
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Top Navigation -->
    <nav class="bg-gray-800 text-white shadow-lg fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo and Menu Button -->
                <div class="flex items-center">
                    <button id="sidebarToggle" class="p-2 rounded-md hover:bg-gray-700">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="flex items-center ml-4">
                        <i class="fas fa-boxes text-blue-400 text-xl mr-3"></i>
                        <span class="text-xl font-bold">Inventory Management- Admin</span>
                    </div>
                </div>

                <!-- User Menu -->
                <div class="relative">
                    <button id="userDropdown" class="flex items-center space-x-2 p-2 rounded-md hover:bg-gray-700">
                        <i class="fas fa-user-shield"></i>
                        <span>{{ Auth::user()->name ?? 'Admin' }}</span>
                        <i class="fas fa-chevron-down text-sm"></i>
                    </button>
                    <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 text-gray-800 z-50">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="flex min-h-screen pt-16">
        <!-- Admin Sidebar -->
        <div id="sidebar" class="bg-gray-800 text-white w-64 min-h-screen fixed left-0 top-16 transform transition-transform duration-300 ease-in-out -translate-x-full lg:translate-x-0 z-40 sidebar-transition">
            <div class="p-6 h-full overflow-y-auto">
                <!-- Welcome Section -->
                <div class="mb-8 p-4 bg-gray-700 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-user-shield text-white text-lg"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-gray-300">Welcome back</p>
                            <p class="font-semibold">{{ Auth::user()->name ?? 'Admin' }}</p>
                            <p class="text-xs text-blue-400 mt-1">Administrator</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation Menu - ADMIN VERSION -->
                <nav class="space-y-2">
                    <!-- Dashboard -->
                    <a href="{{ url('/admin/dashboard') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-700 {{ request()->is('admin/dashboard') ? 'bg-gray-700' : '' }}">
                        <i class="fas fa-tachometer-alt w-5 text-center"></i>
                        <span>Admin Dashboard</span>
                    </a>

                    <!-- Admin Tools Section -->
                    <div class="space-y-1">
                        <button type="button" class="admin-menu-toggle flex items-center justify-between w-full p-3 rounded-lg hover:bg-gray-700 {{ request()->is('admin*') ? 'bg-gray-700' : '' }}">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-cogs w-5 text-center"></i>
                                <span>Admin Tools</span>
                            </div>
                            <i class="fas fa-chevron-down text-sm transition-transform duration-200"></i>
                        </button>
                        <div id="adminSubmenu" class="ml-8 space-y-1 submenu-transition hidden">
                            <a href="{{ route('categories.create') }}" class="flex items-center space-x-2 p-2 rounded hover:bg-gray-700 text-sm">
                                 <i class="fas fa-plus w-4 text-center"></i>
                                 <span>Create Category</span>
                            </a>
                            <a href="{{ route('categories.index') }}" class="flex items-center space-x-2 p-2 rounded hover:bg-gray-700 text-sm">
                                <i class="fas fa-list w-4 text-center"></i>
                                <span>Manage Categories</span>
                            </a>
                            <a href="{{ url('/admin/users') }}" class="flex items-center space-x-2 p-2 rounded hover:bg-gray-700 text-sm">
                                <i class="fas fa-users-cog w-4 text-center"></i>
                                <span>User Management</span>
                            </a>
                            <a href="{{ url('/admin/settings') }}" class="flex items-center space-x-2 p-2 rounded hover:bg-gray-700 text-sm">
                                <i class="fas fa-sliders-h w-4 text-center"></i>
                                <span>System Settings</span>
                            </a>
                        </div>
                    </div>

                    <!-- Products Management -->
                    <div class="space-y-1">
                        <button type="button" class="products-menu-toggle flex items-center justify-between w-full p-3 rounded-lg hover:bg-gray-700 {{ request()->is('products*') ? 'bg-gray-700' : '' }}">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-boxes w-5 text-center"></i>
                                <span>Products Management</span>
                            </div>
                            <i class="fas fa-chevron-down text-sm transition-transform duration-200"></i>
                        </button>
                        <div id="productsSubmenu" class="ml-8 space-y-1 submenu-transition hidden">
                            <a href="{{ url('/admin/products/create') }}" class="block p-2 rounded hover:bg-gray-700 text-sm">Add New Product</a>
                            <a href="{{ url('/admin/products') }}" class="block p-2 rounded hover:bg-gray-700 text-sm">All Products</a>
                            <a href="{{ url('/admin/products/stock') }}" class="block p-2 rounded hover:bg-gray-700 text-sm">Stock Management</a>
                            <a href="{{ url('/admin/products/categories') }}" class="block p-2 rounded hover:bg-gray-700 text-sm">Product Categories</a>
                        </div>
                    </div>

                    <!-- Orders Management -->
                    <div class="space-y-1">
                        <button type="button" class="orders-menu-toggle flex items-center justify-between w-full p-3 rounded-lg hover:bg-gray-700 {{ request()->is('orders*') ? 'bg-gray-700' : '' }}">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-shopping-cart w-5 text-center"></i>
                                <span>Orders Management</span>
                            </div>
                            <i class="fas fa-chevron-down text-sm transition-transform duration-200"></i>
                        </button>
                        <div id="ordersSubmenu" class="ml-8 space-y-1 submenu-transition hidden">
                            <a href="{{ url('/admin/orders') }}" class="block p-2 rounded hover:bg-gray-700 text-sm">All Orders</a>
                            <a href="{{ url('/admin/orders/pending') }}" class="block p-2 rounded hover:bg-gray-700 text-sm">Pending Orders</a>
                            <a href="{{ url('/admin/orders/completed') }}" class="block p-2 rounded hover:bg-gray-700 text-sm">Completed Orders</a>
                            <a href="{{ url('/admin/orders/analytics') }}" class="block p-2 rounded hover:bg-gray-700 text-sm">Order Analytics</a>
                        </div>
                    </div>

                    <!-- Sales & Reports -->
                    <div class="space-y-1">
                        <button type="button" class="sales-menu-toggle flex items-center justify-between w-full p-3 rounded-lg hover:bg-gray-700 {{ request()->is('sales*') ? 'bg-gray-700' : '' }}">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-chart-line w-5 text-center"></i>
                                <span>Sales & Reports</span>
                            </div>
                            <i class="fas fa-chevron-down text-sm transition-transform duration-200"></i>
                        </button>
                        <div id="salesSubmenu" class="ml-8 space-y-1 submenu-transition hidden">
                            <a href="{{ url('/admin/reports/sales') }}" class="block p-2 rounded hover:bg-gray-700 text-sm">Sales Reports</a>
                            <a href="{{ url('/admin/reports/inventory') }}" class="block p-2 rounded hover:bg-gray-700 text-sm">Inventory Reports</a>
                            <a href="{{ url('/admin/reports/customers') }}" class="block p-2 rounded hover:bg-gray-700 text-sm">Customer Reports</a>
                            <a href="{{ url('/admin/reports/analytics') }}" class="block p-2 rounded hover:bg-gray-700 text-sm">Advanced Analytics</a>
                        </div>
                    </div>

                    <!-- Customer Management -->
                    <div class="space-y-1">
                        <button type="button" class="customers-menu-toggle flex items-center justify-between w-full p-3 rounded-lg hover:bg-gray-700 {{ request()->is('customers*') ? 'bg-gray-700' : '' }}">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-users w-5 text-center"></i>
                                <span>Customer Management</span>
                            </div>
                            <i class="fas fa-chevron-down text-sm transition-transform duration-200"></i>
                        </button>
                        <div id="customersSubmenu" class="ml-8 space-y-1 submenu-transition hidden">
                            <a href="{{ url('/admin/customers') }}" class="block p-2 rounded hover:bg-gray-700 text-sm">All Customers</a>
                            <a href="{{ url('/admin/customers/create') }}" class="block p-2 rounded hover:bg-gray-700 text-sm">Add Customer</a>
                            <a href="{{ url('/admin/customers/groups') }}" class="block p-2 rounded hover:bg-gray-700 text-sm">Customer Groups</a>
                        </div>
                    </div>

                    <!-- Switch to User View -->
                    <a href="{{ url('/dashboard') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-700 mt-8 border-t border-gray-600 pt-4">
                        <i class="fas fa-exchange-alt w-5 text-center"></i>
                        <span>Switch to User View</span>
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content Area -->
        <div id="mainContent" class="flex-1 transition-all duration-300 lg:ml-0">
            <div class="p-6">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Backdrop for mobile sidebar -->
    <div id="backdrop" class="fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden hidden"></div>

    <script>
        // Sidebar state management
        let sidebarOpen = false;

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('backdrop');
            const mainContent = document.getElementById('mainContent');

            sidebarOpen = !sidebarOpen;

            if (window.innerWidth >= 1024) {
                // Desktop behavior
                if (sidebarOpen) {
                    sidebar.classList.remove('-translate-x-full');
                    sidebar.classList.add('lg:translate-x-0');
                    mainContent.classList.remove('lg:ml-64');
                } else {
                    sidebar.classList.add('-translate-x-full');
                    sidebar.classList.remove('lg:translate-x-0');
                    mainContent.classList.add('lg:ml-0');
                }
            } else {
                // Mobile behavior
                if (sidebarOpen) {
                    sidebar.classList.remove('-translate-x-full');
                    backdrop.classList.remove('hidden');
                } else {
                    sidebar.classList.add('-translate-x-full');
                    backdrop.classList.add('hidden');
                }
            }
        }

        // Sidebar Toggle
        document.getElementById('sidebarToggle').addEventListener('click', toggleSidebar);

        // Backdrop click to close sidebar (mobile only)
        document.getElementById('backdrop').addEventListener('click', function() {
            if (window.innerWidth < 1024) {
                toggleSidebar();
            }
        });

        // Dropdown Toggle
        document.getElementById('userDropdown').addEventListener('click', function() {
            document.getElementById('dropdownMenu').classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('dropdownMenu');
            const button = document.getElementById('userDropdown');
            if (!button.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });

        // Submenu toggle functionality
        function setupSubmenu(toggleClass, submenuId) {
            const toggle = document.querySelector(toggleClass);
            if (!toggle) return;

            const submenu = document.getElementById(submenuId);
            const chevron = toggle.querySelector('.fa-chevron-down');

            toggle.addEventListener('click', function() {
                // Toggle submenu visibility
                if (submenu) submenu.classList.toggle('hidden');

                // Rotate chevron icon
                if (chevron) chevron.classList.toggle('rotate-180');

                // Close other submenus
                closeOtherSubmenus(submenuId);
            });
        }

        function closeOtherSubmenus(currentSubmenuId) {
            const allSubmenus = ['adminSubmenu', 'productsSubmenu', 'ordersSubmenu', 'salesSubmenu', 'customersSubmenu'];
            const allToggles = ['.admin-menu-toggle', '.products-menu-toggle', '.orders-menu-toggle', '.sales-menu-toggle', '.customers-menu-toggle'];

            allSubmenus.forEach((submenuId, index) => {
                if (submenuId !== currentSubmenuId) {
                    const submenu = document.getElementById(submenuId);
                    const toggle = document.querySelector(allToggles[index]);
                    const chevron = toggle?.querySelector('.fa-chevron-down');

                    if (submenu) submenu.classList.add('hidden');
                    if (chevron) chevron.classList.remove('rotate-180');
                }
            });
        }

        // Handle window resize
        function handleResize() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('backdrop');
            const mainContent = document.getElementById('mainContent');

            if (window.innerWidth >= 1024) {
                // Desktop: show sidebar by default, hide backdrop
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('lg:translate-x-0');
                backdrop.classList.add('hidden');
                mainContent.classList.remove('lg:ml-64');
                sidebarOpen = true;
            } else {
                // Mobile: hide sidebar by default
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('lg:translate-x-0');
                backdrop.classList.add('hidden');
                mainContent.classList.remove('lg:ml-64');
                sidebarOpen = false;
            }
        }

        // Initialize all functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Set initial state
            handleResize();

            // Initialize submenus
            setupSubmenu('.admin-menu-toggle', 'adminSubmenu');
            setupSubmenu('.products-menu-toggle', 'productsSubmenu');
            setupSubmenu('.orders-menu-toggle', 'ordersSubmenu');
            setupSubmenu('.sales-menu-toggle', 'salesSubmenu');
            setupSubmenu('.customers-menu-toggle', 'customersSubmenu');

            // Handle window resize
            window.addEventListener('resize', handleResize);
        });
    </script>

    @yield('scripts')
</body>
</html>
