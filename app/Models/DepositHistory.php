<?php

namespace App\Models;

use App\Http\Traits\FilterByUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepositHistory extends Model
{
    use FilterByUser,HasFactory;

    protected $fillable = ['user_id', 'amount', 'description', 'owner_id'];
}
