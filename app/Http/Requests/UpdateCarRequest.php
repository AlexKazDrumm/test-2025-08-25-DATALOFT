<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCarRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'brand_id'     => ['sometimes','exists:brands,id'],
            'car_model_id' => ['sometimes','exists:car_models,id'],
            'year'         => ['nullable','integer','min:1900','max:'.(date('Y')+1)],
            'mileage'      => ['nullable','integer','min:0'],
            'color'        => ['nullable','string','max:64'],
        ];
    }
}
