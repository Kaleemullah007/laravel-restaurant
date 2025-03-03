<?php

namespace App\Models;

use App\Http\Traits\FilterByUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use FilterByUser;
    use HasFactory;

    protected $guarded = ['id'];

    public function SaleProduct()
    {
        return $this->hasMany('App\Models\Sale');
    }

    public function PurchaseProduct()
    {
        return $this->hasMany('App\Models\Purchase');
    }

    public function ProductionProduct()
    {
        return $this->hasMany('App\Models\ProductionHistory');
    }
    // public function getCreatedAtPSTAttribute()
    // {
    //     return \Carbon\Carbon::parse($this->attributes['created_at'])->timezone('Asia/Karachi')->format('Y-m-d H:i:s');
    // }

}
