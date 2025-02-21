<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExpenseRequest extends FormRequest
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
            'amount' => 'required|decimal:0,2',
            'name' => 'required|Max:255',
            'date' => 'required|date_format:Y-m-d',
            'owner_id' => 'required|integer',
        ];
    }

    // Adding Owner Id To all Requests
    protected function prepareForValidation()
    {
        $this->merge([
            'owner_id' => auth()->id(),
        ]);
    }
}
