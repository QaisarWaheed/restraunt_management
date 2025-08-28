<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'price',
        'category_id',
        'image',
        'is_active',
        'is_featured',
        'stock_quantity',
        'sku',
        'sort_order',
        'barcode',
        'cost_price',
        'min_stock_level',
        'status',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'stock_quantity' => 'integer',
        'min_stock_level' => 'integer'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public static function reorder(array $order)
    {
        foreach ($order as $position => $id) {
            static::where('id', $id)->update(['sort_order' => $position]);
        }
    }

    public static function getActiveProducts()
    {
        return static::with('category')
            ->where('is_active', true)
            ->whereHas('category', function($query) {
                $query->where('is_active', true);
            })
            ->orderBy('sort_order')
            ->get();
    }
}
