<?php
// app/Models/Order.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number', 'customer_id', 'product_id', 'quantity',
        'unit_price', 'total_amount', 'order_date', 'status'
    ];
    protected $casts = [
        'order_date' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $order->order_number = 'ORD-' . date('Ymd') . '-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
        });

        static::created(function ($order) {
            $order->product->decrement('stock', $order->quantity);
        });

        static::updated(function ($order) {
            if ($order->isDirty('status') && $order->status === 'Cancelled') {
                $order->product->increment('stock', $order->quantity);
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
