<?php
// app/Models/Order.php
// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

// class Order extends Model
// {
//     use HasFactory;

//     protected $fillable = [
//         'order_number', 'customer_id', 'product_id', 'quantity',
//         'unit_price', 'total_amount', 'order_date', 'status'
//     ];
//     protected $casts = [
//         'order_date' => 'date',
//     ];

//     protected static function boot()
//     {
//         parent::boot();

//         static::creating(function ($order) {
//             $order->order_number = 'ORD-' . date('Ymd') . '-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
//         });

//         static::created(function ($order) {
//             $order->product->decrement('stock', $order->quantity);
//         });

//         static::updated(function ($order) {
//             if ($order->isDirty('status') && $order->status === 'Cancelled') {
//                 $order->product->increment('stock', $order->quantity);
//             }
//         });
//     }

//     public function customer()
//     {
//         return $this->belongsTo(Customer::class);
//     }

//     public function product()
//     {
//         return $this->belongsTo(Product::class);
//     }
// }



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number', 'customer_id', 'product_id', 'quantity',
        'unit_price', 'total_amount', 'order_date', 'status',
    ];

    protected $casts = [
        'order_date' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            // FIX #1: Replaced rand(1, 999) with a daily sequential counter.
            // rand() only has 999 slots per day — two orders created at the same
            // second would collide on the unique order_number column and crash.
            $count = Order::whereDate('created_at', today())->count() + 1;
            $order->order_number = 'ORD-' . date('Ymd') . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
        });

        static::created(function ($order) {
            // FIX #2: Moved stock decrement to 'created' (fires after DB save succeeds).
            // Previously it was in 'creating' — if the INSERT failed, stock was already
            // decremented with no matching order record.
            // FIX #3: Using Product::find() with null-safe operator instead of
            // $order->product->decrement() to avoid null reference if product is missing.
            Product::find($order->product_id)?->decrement('stock', $order->quantity);
        });

        static::updated(function ($order) {
            // Restore stock when an order is cancelled
            if ($order->isDirty('status') && $order->status === 'Cancelled') {
                Product::find($order->product_id)?->increment('stock', $order->quantity);
            }
        });
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
