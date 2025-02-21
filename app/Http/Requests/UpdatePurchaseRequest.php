<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePurchaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {

        return [
            'user_id' => 'required|integer',
            'product_id' => 'required|integer',
            'qty' => 'required',
            'price' => 'required',
            'sale_price' => 'required',
            'owner_id' => 'required|integer',
            'total' => 'required|decimal:0,2',
            'sale_price' => 'gte:price',
            'paid_amount' => 'required|decimal:0,2',
            'remaining_amount' => 'required|decimal:0,2',
        ];
    }

    // Adding Owner Id To all Requests
    protected function prepareForValidation()
    {
        $total = str_replace(',', '', number_format(($this->qty * $this->price), 2));
        $remaining = $total - $this->paid_amount;

        $this->merge([
            'owner_id' => auth()->id(),
            'total' => $total,
            'remaining_amount' => $remaining,
        ]);
    }
}
