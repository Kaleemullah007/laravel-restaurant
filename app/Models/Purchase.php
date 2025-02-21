<?php

namespace App\Models;

use App\Http\Traits\FilterByUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Purchase extends Model
{
    use FilterByUser;
    use HasFactory;

    protected $fillable = ['sale_price', 'price', 'user_id', 'qty', 'owner_id', 'total', 'name', 'product_id', 'unit', 'paid_amount', 'remaining_amount'];

    public function vendor(): BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
