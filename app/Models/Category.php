<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Scope active categories
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get categories for dropdowns
     */
    public static function getForDropdown()
    {
        return self::active()->orderBy('name')->pluck('name', 'id');
    }

    /**
     * Relationship with products
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
