<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StoreCustomerRequest extends FormRequest
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
            // 'email'=> 'nullable|sometimes|email|unique:users,email',
            'email' => [
                'nullable',
                'sometimes',
                'email',
                Rule::unique('users', 'email')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id);
                }),
            ],
            'phone' => 'required',
            'user_type' => 'required',
            'owner_id' => 'required',
            'password' => 'required',
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date',
            'is_tester' => 'required|boolean',
            'change_price' => 'required|boolean',
            'currency' => 'required',
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
            'password' => Hash::make($this->password),
            'is_tester' => false,
            'change_price' => $change_price,
            'currency' => auth()->user()->currency,
            'email_verified_at' => now(),
        ];

        $extraparam = [];
        if ($this->user_type == 'admin' && auth()->user()->user_type == 'superadmin') {
            $extraparam = ['start_date' => date('Y-m-d'),
                'end_date' => Carbon::now()->addYear(1)->format('Y-m-d'),
                'is_tester' => false,
                'change_price' => $change_price,
            ];

        }
        if ($this->user_type == 'tester' && auth()->user()->user_type == 'superadmin') {
            $extraparam = [
                'user_type' => 'admin',
                'is_tester' => true,
                'change_price' => $change_price,
            ];
        }

        $this->merge(array_merge($data, $extraparam));
    }

    public function messages()
    {
        return [
            'email.unique' => 'The email must be unique for the specified owner.',
            // Add other custom messages as needed
        ];
    }
}
