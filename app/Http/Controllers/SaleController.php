<?php
// app/Http/Controllers/SaleController.php
// namespace App\Http\Controllers;

// use App\Models\Sale;
// use App\Models\Customer;
// use App\Models\Product;
// use Illuminate\Http\Request;
// use Barryvdh\DomPDF\Facade\Pdf;

// class SaleController extends Controller
// {
//     public function index()
//     {
//         $sales = Sale::with(['customer', 'product'])->latest()->paginate(10);
//         return view('sales.index', compact('sales'));
//     }

//     public function create()
//     {
//         $customers = Customer::all();
//         $products = Product::where('is_active', true)->where('stock', '>', 0)->get();
//         return view('sales.create', compact('customers', 'products'));
//     }

//     public function store(Request $request)
//     {
//         $request->validate([
//             'customer_id' => 'required|exists:customers,id',
//             'product_id' => 'required|exists:products,id',
//             'quantity' => 'required|integer|min:1',
//             'payment_status' => 'required|in:Done,Pending',
//             'invoice_date' => 'required|date'
//         ]);

//         $product = Product::findOrFail($request->product_id);

//         if ($product->stock < $request->quantity) {
//             return back()->with('error', 'Insufficient stock. Available: ' . $product->stock);
//         }

//         $sale = new Sale();
//         $sale->customer_id = $request->customer_id;
//         $sale->product_id = $request->product_id;
//         $sale->quantity = $request->quantity;
//         $sale->price = $product->sale_price;
//         $sale->total = $request->quantity * $product->sale_price;
//         $sale->payment_status = $request->payment_status;
//         $sale->invoice_date = $request->invoice_date;
//         $sale->save();

//         return redirect()->route('sales.index')
//             ->with('success', 'Sale created successfully.');
//     }

//     public function downloadInvoice(Sale $sale)
//     {
//         $sale->load(['customer', 'product']);
//         $pdf = PDF::loadView('sales.invoice-pdf', compact('sale'));
//         return $pdf->download('invoice-' . $sale->invoice_number . '.pdf');
//     }

//     public function downloadOrder(Order $order)
//     {
//         $order->load(['customer', 'product']);
//         $pdf = PDF::loadView('orders.order-pdf', compact('order'));
//         return $pdf->download('order-' . $order->order_number . '.pdf');
//     }
// public function togglePayment(Sale $sale)
// {
//     $newStatus = $sale->payment_status === 'Done' ? 'Pending' : 'Done';

//     $sale->update([
//         'payment_status' => $newStatus
//     ]);

//     return response()->json(['success' => true, 'new_status' => $newStatus]);
// }
// }



namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with(['customer', 'product'])->latest()->paginate(10);
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $customers = Customer::all();
        $products = Product::where('is_active', true)->where('stock', '>', 0)->get();
        return view('sales.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id'    => 'required|exists:customers,id',
            'product_id'     => 'required|exists:products,id',
            'quantity'       => 'required|integer|min:1',
            'payment_status' => 'required|in:Done,Pending',
            'invoice_date'   => 'required|date',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Insufficient stock. Available: ' . $product->stock);
        }

        $sale = new Sale();
        $sale->customer_id    = $request->customer_id;
        $sale->product_id     = $request->product_id;
        $sale->quantity       = $request->quantity;
        $sale->price          = $product->sale_price;
        $sale->total          = $request->quantity * $product->sale_price;
        $sale->payment_status = $request->payment_status;
        $sale->invoice_date   = $request->invoice_date;
        $sale->save();

        return redirect()->route('sales.index')
            ->with('success', 'Sale created successfully.');
    }

    public function downloadInvoice(Sale $sale)
    {
        $sale->load(['customer', 'product']);
        $pdf = Pdf::loadView('sales.invoice-pdf', compact('sale'));
        return $pdf->download('invoice-' . $sale->invoice_number . '.pdf');
    }

    // FIX #1: Removed dead downloadOrder(Order $order) method — Order was never
    // imported in this file, causing a fatal error. Order downloads are handled
    // by OrderController::downloadOrder where the import exists.

    // FIX #2: Changed from GET to PATCH (route updated in web.php to match)
    public function togglePayment(Sale $sale)
    {
        $newStatus = $sale->payment_status === 'Done' ? 'Pending' : 'Done';

        $sale->update([
            'payment_status' => $newStatus,
        ]);

        return response()->json(['success' => true, 'new_status' => $newStatus]);
    }
}
