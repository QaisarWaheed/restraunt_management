<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tracking_id',
        'customer_id',
        'restaurant_id',
        'total_amount',
        'status',
        'payment_status',
        'payment_method',
        'delivery_address',
        'special_instructions'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2'
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }
} 