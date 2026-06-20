<?php
// app/Models/Product.php
// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

// class Product extends Model
// {
//     use HasFactory;

//     protected $fillable = [
//         'product_code', 'product_name', 'category_id', 'stock',
//         'buy_price', 'sale_price', 'description', 'is_active'
//     ];

//     protected static function boot()
//     {
//         parent::boot();

//         static::creating(function ($product) {
//             $product->product_code = 'PRD-' . date('Ymd') . '-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
//         });
//     }

//     public function category()
//     {
//         return $this->belongsTo(Category::class);
//     }

//     public function orders()
//     {
//         return $this->hasMany(Order::class);
//     }

//     public function sales()
//     {
//         return $this->hasMany(Sale::class);
//     }

//     public function getStockStatusAttribute()
//     {
//         if ($this->stock <= 0) {
//             return 'out-of-stock';
//         } elseif ($this->stock < 10) {
//             return 'low-stock';
//         }
//         return 'in-stock';
//     }
// }




namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_code', 'product_name', 'category_id', 'stock',
        'buy_price', 'sale_price', 'description', 'is_active',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            // FIX #1: Replaced rand(1, 999) with a daily sequential counter.
            // rand() only has 999 slots per day — two products created at the
            // same second would collide on the unique product_code column and crash.
            $count = Product::whereDate('created_at', today())->count() + 1;
            $product->product_code = 'PRD-' . date('Ymd') . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function getStockStatusAttribute()
    {
        if ($this->stock <= 0) {
            return 'out-of-stock';
        } elseif ($this->stock < 10) {
            return 'low-stock';
        }
        return 'in-stock';
    }
}
