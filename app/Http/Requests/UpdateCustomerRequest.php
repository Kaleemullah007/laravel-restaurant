<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UpdateCustomerRequest extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            'name' => 'required',
            // 'email'=> 'nullable|sometimes|email|unique:users,email,'.$this->customer->id,
            'email' => [
                'nullable',
                'sometimes',
                'email',
                Rule::unique('users', 'email')
                    ->ignore($this->customer) // $this->user is automatically resolved in resourceful routes
                    ->where(function ($query) {
                        return $query->where('owner_id', $this->owner_id);
                    }),
            ],

            'phone' => 'required',
            // 'user_type'=>'required',
            'owner_id' => 'required',
            'password' => 'nullable||sometimes|string',
            'page' => 'required|integer',
            'is_tester' => 'required|boolean',
            'change_price' => 'required|boolean',
        ];
    }

    protected function prepareForValidation()
    {
        $change_price = false;
        if ($this->change_price == 'on') {
            $change_price = true;
        }
        $data = [
            'owner_id' => auth()->id(),
            'user_type' => $this->user_type,
            'name' => $this->first_name.' '.$this->last_name,
            'password' => $this->password ? Hash::make('password') : $this->customer->password,
            'is_tester' => false,
            'change_price' => $change_price,
        ];

        $extraparam = [];
        if ($this->user_type == 'tester' && auth()->user()->user_type == 'superadmin') {
            $extraparam = [
                'user_type' => 'admin',
                'is_tester' => true,
            ];
        }
        $this->merge(array_merge($data, $extraparam));
    }
}
