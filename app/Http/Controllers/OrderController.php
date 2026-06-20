<?php
// app/Http/Controllers/OrderController.php
// namespace App\Http\Controllers;

// use App\Models\Order;
// use App\Models\Customer;
// use App\Models\Product;
// use Illuminate\Http\Request;
// use Barryvdh\DomPDF\Facade\Pdf;

// class OrderController extends Controller
// {
//     public function index()
//     {
//         $orders = Order::with(['customer', 'product'])->latest()->paginate(10);
//         return view('orders.index', compact('orders'));
//     }

//     public function create()
//     {
//         $customers = Customer::all();
//         $products = Product::where('is_active', true)->where('stock', '>', 0)->get();
//         return view('orders.create', compact('customers', 'products'));
//     }

//     public function store(Request $request)
//     {
//         $request->validate([
//             'customer_id' => 'required|exists:customers,id',
//             'product_id' => 'required|exists:products,id',
//             'quantity' => 'required|integer|min:1',
//             'order_date' => 'required|date'
//         ]);

//         $product = Product::findOrFail($request->product_id);

//         if ($product->stock < $request->quantity) {
//             return back()->with('error', 'Insufficient stock. Available: ' . $product->stock);
//         }

//         $order = new Order();
//         $order->customer_id = $request->customer_id;
//         $order->product_id = $request->product_id;
//         $order->quantity = $request->quantity;
//         $order->unit_price = $product->sale_price;
//         $order->total_amount = $request->quantity * $product->sale_price;
//         $order->order_date = $request->order_date;
//         $order->save();

//         return redirect()->route('orders.index')
//             ->with('success', 'Order created successfully.');
//     }

//     public function updateStatus(Request $request, Order $order)
//     {
//         $request->validate([
//             'status' => 'required|in:Pending,Delivered'
//         ]);

//         $order->update(['status' => $request->status]);

//         return redirect()->route('orders.index')
//             ->with('success', 'Order status updated successfully.');
//     }

//     public function pendingOrders()
//     {
//         $orders = Order::with(['customer', 'product'])
//             ->where('status', 'Pending')
//             ->latest()
//             ->paginate(10);

//         return view('orders.pending', compact('orders'));
//     }

//     public function deliveredOrders()
//     {
//         $orders = Order::with(['customer', 'product'])
//             ->where('status', 'Delivered')
//             ->latest()
//             ->paginate(10);

//         return view('orders.delivered', compact('orders'));
//     }

//     public function destroy(Order $order)
//     {
//         $order->delete();

//         return redirect()->route('orders.index')
//             ->with('success', 'Order deleted successfully.');
//     }
//     public function downloadOrder(Order $order)
// {
//     $order->load(['customer', 'product.category']);
//     $pdf = PDF::loadView('orders.order-pdf', compact('order'));
//     return $pdf->download('order-' . $order->order_number . '.pdf');
// }
// }



namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
// FIX #1: Added missing PDF import — was causing "Class PDF not found" fatal error
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['customer', 'product'])->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::all();
        $products = Product::where('is_active', true)->where('stock', '>', 0)->get();
        return view('orders.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'product_id'  => 'required|exists:products,id',
            'quantity'    => 'required|integer|min:1',
            'order_date'  => 'required|date',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Insufficient stock. Available: ' . $product->stock);
        }

        $order = new Order();
        $order->customer_id  = $request->customer_id;
        $order->product_id   = $request->product_id;
        $order->quantity     = $request->quantity;
        $order->unit_price   = $product->sale_price;
        $order->total_amount = $request->quantity * $product->sale_price;
        $order->order_date   = $request->order_date;
        $order->save();

        return redirect()->route('orders.index')
            ->with('success', 'Order created successfully.');
    }

    public function updateStatus(Request $request, Order $order)
    {
        // FIX #2: Added 'Cancelled' to validator — Order::boot already handles
        // stock restoration on Cancelled, but the validator was blocking it.
        $request->validate([
            'status' => 'required|in:Pending,Delivered,Cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->route('orders.index')
            ->with('success', 'Order status updated successfully.');
    }

    public function pendingOrders()
    {
        $orders = Order::with(['customer', 'product'])
            ->where('status', 'Pending')
            ->latest()
            ->paginate(10);

        return view('orders.pending', compact('orders'));
    }

    public function deliveredOrders()
    {
        $orders = Order::with(['customer', 'product'])
            ->where('status', 'Delivered')
            ->latest()
            ->paginate(10);

        return view('orders.delivered', compact('orders'));
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('orders.index')
            ->with('success', 'Order deleted successfully.');
    }

    public function downloadOrder(Order $order)
    {
        $order->load(['customer', 'product.category']);
        // FIX #3: PDF now works because Pdf is imported above
        $pdf = Pdf::loadView('orders.order-pdf', compact('order'));
        return $pdf->download('order-' . $order->order_number . '.pdf');
    }
}
