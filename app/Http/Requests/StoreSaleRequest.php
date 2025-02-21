<?php

namespace App\Http\Requests;

use App\Rules\ProductStockRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSaleRequest extends FormRequest
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
            'products' => 'required',

            'products.*.product_id' => 'required|max:255',
            'products' => [new ProductStockRule],
            'products.*.qty' => 'required|decimal:0,10',
            'products.*.sale_price' => 'sometimes|nullable|decimal:0,10',
            'owner_id' => 'required|integer',
            'employee_id' => 'sometimes|integer',
            'discount' => 'required|decimal:0,2',
            'payment_status' => 'required',
            'payment_method' => 'required',
            'tax' => 'nullable|decimal:0,2|min:0|max:100',
            'shipping' => 'nullable|decimal:0,2',
            'paid_amount' => 'required|decimal:0,2',
            'remaining_amount' => 'required',
            'total' => 'required|decimal:0,2',
            'due_date' => 'sometimes|nullable|date',
            'sale_id' => 'nullable|integer',
            'is_edit' => 'required|boolean',
        ];
    }

    // Adding Owner Id To all Requests
    protected function prepareForValidation()
    {

        $is_edit = false;
        // dd($this->is_edit);
        if ($this->is_edit == 'on') {
            $is_edit = true;
        }

        if (auth()->user()->user_type == 'employee') {
            $this->merge([
                'owner_id' => auth()->user()->owner_id,
                'employee_id' => auth()->id(),
                'total' => 0.0,
                'is_edit' => $is_edit,
                // 'flag'=>$flag,
            ]);

        } else {
            $this->merge([
                'owner_id' => auth()->id(),
                'total' => 0.0,
                'is_edit' => $is_edit,
                // 'flag'=>$flag,
            ]);
        }

    }
}
