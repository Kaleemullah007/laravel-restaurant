<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'sale_id',
        'product_name',
        'variation',
        'qty',
        'cost_price',
        'sale_price',
        'employee_id',
        'unit',
        'deal_products',
    ];

    protected $casts = ['deal_products' => 'array'];

    public function Product(): BelongsTo
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }
}
