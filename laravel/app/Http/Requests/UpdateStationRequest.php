<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStationRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string',
            'city' => 'sometimes|string',
            'location' => 'sometimes|string',
            'power' => 'sometimes|numeric|min:0',
            'is_available' => 'sometimes|boolean',
            'connector_type_id' => 'sometimes|exists:connector_types,id',
        ];
    }
}
