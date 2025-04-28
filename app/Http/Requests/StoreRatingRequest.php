<?php

namespace App\Http\Requests;

use App\Enums\RatingCriteriaEnum;
use Illuminate\Foundation\Http\FormRequest;

class StoreRatingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array>
     */
    public function rules(): array
    {
        return [
            'value' => ['required', 'integer', 'between:1,10'],
            'notes' => ['nullable', 'string'],
            'criteria' => ['required', 'string', 'in:'.implode(',', RatingCriteriaEnum::toArrayName())],
        ];
    }
}
