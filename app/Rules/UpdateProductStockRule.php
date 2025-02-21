<?php

namespace App\Rules;

use App\Models\Product;
use App\Models\SaleProduct;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UpdateProductStockRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        // $products = array_filter($value);
        $products = array_filter($value, function ($values) {
            return $values['product_id'] != 'Choose';
        });
        if (count($products) == 0) {
            $fail('Please select at least one product');
        }

        $sale_id = request()->segment(2);

        // $productIds = collect($value)->pluck('product_id');
        $productIds = collect($value)->pluck('product_id');
        $productIds = $productIds->reject(function ($va) {
            return $va == 'Choose';
        })->all();

        $DBProducts = Product::find($productIds)->keyBy('id');

        $DBSaleProducts = SaleProduct::where('sale_id', $sale_id)->get()->keyBy('product_id');
        // dd($DBProducts,$DBSaleProducts);

        $errorText = '';
        foreach ($products as $index => $products_array) {
            $ordered_qty = $DBSaleProducts[$products_array['product_id']]->qty ?? 0;
            if (($DBProducts[$products_array['product_id']]->stock + $ordered_qty) < $products_array['qty']) {
                $errorText .= nl2br(e('Sorry, we have only '.
                $DBProducts[$products_array['product_id']]->stock.' of '.
                $DBProducts[$products_array['product_id']]->name.' left in stock. '));
                if ($errorText != '') {
                    $fail($errorText);
                }
            }
        }

    }
}
