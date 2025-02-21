<?php

namespace App\Models;

use App\Http\Traits\FilterByUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use FilterByUser;
    use HasFactory;

    protected $fillable = ['name', 'amount', 'date', 'owner_id'];
}
