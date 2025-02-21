<?php

namespace App\Models;

use App\Http\Traits\FilterByUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use FilterByUser,HasFactory;

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
        'owner_id',
        'start_date',
        'end_date',
        'is_tester',
        'change_price',
        'email_verified_at',
        'currency',
        'first_name',
        'last_name',
    ];

    protected $dates = ['last_login_at'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function customerSale(): HasMany
    {
        return $this->hasMany('App\Models\Sale', 'user_id', 'id');
    }

    public function DespositSum(): HasMany
    {
        return $this->hasMany('App\Models\DepositHistory', 'user_id', 'id');
    }

    public function vendorProdudctPurchases(): HasMany
    {
        return $this->hasMany(Purchase::class, 'user_id', 'id');
    }
}
