<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PropertyUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100|unique:properties,name,'.$this->id,
            'description' => 'required|string',
            'address' => 'required|string',
            'floor_area_width' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'floor_area_length' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'land_area_width' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'land_area_length' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'amenities' => 'nullable|array',
            'amenities.*' => 'nullable|string|max:100',
            'amenityIds' => 'nullable|array',
        ];
    }
}
