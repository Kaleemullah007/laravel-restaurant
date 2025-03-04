<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
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
        $deal = [
            'deal_name' => 'required',
            'start_time' => ['nullable', 'date'], // Optional but must be a valid date
            'end_time' => ['nullable', 'date', 'after:start_time'], // Optional but must be after start_time if provided
            'deal_price' => 'required',
            'status' => 'required',
            'productss' => 'required|array',
            'productss.*.product_id' => 'required|numeric',
            'productss.*.quantity' => 'required|decimal:0,2|gte:1',
            'productss.*.is_swappable' => 'nullable|in:true,false,1,0,on,off',
            'is_always' => 'nullable|boolean',
            'owner_id' => 'required',
           'is_product_value' => 'required|in:true,false,1,0,on,off',
            'product_code' => [
                'required',
                'string', Rule::unique('products', 'product_code')
                    ->ignore($this->product) // Ignore the current product's ID
                    ->where(function ($query) {
                        return $query->where('owner_id', $this->owner_id);
                    }),
            ],

        ];
        if ($this->is_product_value == 0) {
            return $deal;
        }


        return [
            'sale_price' => 'required|gt:0',
            'price' => 'required|gt:0',
            'name' => 'required',
            // 'stock'=>'required|integer',
            // 'product_code' => 'required|string|unique:products,product_code,'.$this->product->id,
            'product_code' => [
                'required',
                'string', Rule::unique('products', 'product_code')
                    ->ignore($this->product) // Ignore the current product's ID
                    ->where(function ($query) {
                        return $query->where('owner_id', $this->owner_id);
                    }),
            ],
            'stock_alert' => 'required|decimal:0,2|gt:0',
            'owner_id' => 'required|integer',
            'image' => 'sometimes|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'variation' => 'nullable|string',
            'unit' => 'required|string',
            'is_product_value' => 'required|in:true,false,1,0,on,off',

        ];
    }

    // Adding Owner Id To all Requests
    protected function prepareForValidation()
    {
        // dd((is_null($this->product_code)||empty($this->product_code))?productCode():$this->product_code);
        // $this->merge([
        //     'owner_id' => auth()->id(),
        //     'product_code' => (is_null($this->product_code) || empty($this->product_code)) ? productCode() : $this->product_code,
        // ]);

        if (session()->has('admin_id')) {
            $owner_id = session()->get('admin_id');
        } else {
            $owner_id = auth()->id();
        }

        if ($this->is_product_value == 0) {
            $this->merge([
                'owner_id' => $owner_id,
                'product_code' => (is_null($this->deal_code) || empty($this->deal_code)) ? productCode() : $this->deal_code,
            ]);
        } else {
            $this->merge([
                'owner_id' => $owner_id,
                'product_code' => (is_null($this->product_code) || empty($this->product_code)) ? productCode() : $this->product_code,
            ]);
        }

    }
}
