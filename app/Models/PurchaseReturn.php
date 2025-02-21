<?php

namespace App\Models;

use App\Http\Traits\FilterByUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseReturn extends Model
{
    use FilterByUser, HasFactory;

    protected $guarded = ['id'];

    // Vendor
    public function vendor(): BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
