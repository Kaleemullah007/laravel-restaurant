<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckPurchaseStockBeforeStoreProduction implements DataAwareRule, ValidationRule
{
    protected $data = [];

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        dd($this->data);
    }

    public function setData(array $data)
    {

        $this->data = $data;

        return $this;

    }
}
