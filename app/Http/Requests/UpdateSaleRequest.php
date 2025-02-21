<?php

namespace App\Http\Requests;

use App\Rules\UpdateProductStockRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSaleRequest extends FormRequest
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

            'products.*.product_id' => 'required|max:255',
            'products' => [new UpdateProductStockRule],
            'products.*.qty' => 'required|decimal:0,10',
            'products.*.sale_price' => 'sometimes|nullable|decimal:0,10',
            'tax' => 'nullable|decimal:0,2|min:0|max:100',
            'shipping' => 'nullable|decimal:0,2',
            'owner_id' => 'required|integer',
            'discount' => 'required|decimal:0,2',
            'payment_status' => 'required',
            'payment_method' => 'required',
            'paid_amount' => 'required|decimal:0,2',
            'remaining_amount' => 'required|decimal:0,2',
            'total' => 'required|decimal:0,2',
            'due_date' => 'sometimes|nullable|date',
        ];
    }

    // Adding Owner Id To all Requests
    protected function prepareForValidation()
    {

        $this->merge([
            'owner_id' => auth()->id(),
            'total' => 0,
            'remaining_amount' => 0,
            // 'flag'=>$flag,
        ]);
    }
}
