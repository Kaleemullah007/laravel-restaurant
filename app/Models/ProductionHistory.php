<?php

namespace App\Models;

use App\Http\Traits\FilterByUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductionHistory extends Model
{
    use FilterByUser,HasFactory;

    protected $fillable = [
        'name',
        'qty',
        'wastage_qty',
        'purchase_id',
        'owner_id',
        'product_id',
    ];

    public function RawMaterial(): BelongsTo
    {
        return $this->belongsTo('App\Models\Purchase', 'purchase_id', 'id');
    }

    public function Product(): BelongsTo
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }
}
