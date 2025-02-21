<?php

namespace App\Rules;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ProductStockRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        $products = array_filter($value, function ($values) {
            return $values['product_id'] != 'Choose';
        });
        // dd($products);
        if (count($products) == 0) {
            $fail('Please select at least one product');
        }

        $productIds = collect($value)->pluck('product_id');
        $productIds = $productIds->reject(function ($va) {
            return $va == 'Choose';
        })->all();

        $DBProducts = Product::find($productIds)->keyBy('id');
        $errorText = '';
        foreach ($products as $index => $products_array) {

            if ($products_array['product_id'] == 'Choose') {
                continue;
            }
            if ($DBProducts[$products_array['product_id']]->stock < $products_array['qty']) {
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
