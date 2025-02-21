<?php

namespace App\Models;

use App\Http\Traits\FilterByUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use FilterByUser;
    use HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'user_type',
        'is_factory_user',
        'picture',
        'status',
        'business_email',
        'business_name',
        'address',
        'postal_code',
        'business_phone',
        'country',
        'invoice_template',
        'per_page',
        'custom_note',
        'custom_note_heading',
        'logo',
    ];
}
