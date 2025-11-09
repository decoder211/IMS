<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\Sale;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Total Stock (sum of all products stock)
        $totalStock = Product::sum('stock');

        // Sold Products (sum of all sales quantities)
        $soldProducts = Sale::sum('quantity');

        // Available Products (count of products with stock > 0)
        $availableProducts = Product::where('stock', '>', 0)->count();

        // Pending Orders (count of pending orders)
        $pendingOrders = Order::where('status', 'Pending')->count();

        return view('dashboard', compact(
            'totalStock',
            'soldProducts',
            'availableProducts',
            'pendingOrders'
        ));
    }
}
