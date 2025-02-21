<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDealRequest extends FormRequest
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
            'deal_name' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'deal_price' => 'required',
            'status' => 'required',
            'productss' => 'required|array',
            'products.*.product_id' => 'required|numeric',
            'products.*.qty' => 'required|decimal:0,2|gte:1',
            'products.*.is_swappable' => 'nullable|boolean',
            'is_always' => 'nullable|boolean',
            'owner_id' => 'required',
            'deal_code' => 'required',
        ];
    }

    // Adding Owner Id To all Requests
    protected function prepareForValidation()
    {
        $flag = false;
        if ($this->status == 'active') {
            $flag = true;
        }

        $this->merge([
            'owner_id' => auth()->id(),
            'status' => $flag,
        ]);
    }
}
