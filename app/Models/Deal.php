<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function dealProducts()
    {
        return $this->hasMany(DealProduct::class);
    }
}
