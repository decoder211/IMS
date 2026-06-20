<?php
// app/Models/Sale.php
// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

// class Sale extends Model
// {
//     use HasFactory;

//     protected $fillable = [
//         'invoice_number', 'customer_id', 'product_id', 'quantity',
//         'price', 'total', 'payment_status', 'invoice_date'
//     ];
//     protected $casts = [
//         'invoice_date' => 'date',
//     ];

//     protected static function boot()
//     {
//         parent::boot();

//         static::creating(function ($sale) {
//             $sale->invoice_number = 'INV-' . date('Ymd') . '-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
//             $sale->product->decrement('stock', $sale->quantity);
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

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number', 'customer_id', 'product_id', 'quantity',
        'price', 'total', 'payment_status', 'invoice_date',
    ];

    protected $casts = [
        'invoice_date' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($sale) {
            // FIX #1: Replaced rand(1, 999) with a daily sequential counter.
            // rand() only has 999 slots per day — two sales at the same second
            // would collide on the unique invoice_number column and crash.
            $count = Sale::whereDate('created_at', today())->count() + 1;
            $sale->invoice_number = 'INV-' . date('Ymd') . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);

            // FIX #2: Removed stock decrement from 'creating'.
            // In 'creating', the record hasn't been saved yet — if the INSERT
            // fails for any reason, stock would already be wrong with no
            // matching sale record to explain it.
        });

        static::created(function ($sale) {
            // FIX #3: Stock decrement now happens AFTER the sale is saved successfully.
            // FIX #4: Using Product::find() with null-safe operator instead of
            // $sale->product->decrement() which would crash if product is null.
            Product::find($sale->product_id)?->decrement('stock', $sale->quantity);
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
