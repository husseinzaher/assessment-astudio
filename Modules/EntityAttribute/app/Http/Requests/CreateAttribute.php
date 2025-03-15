<?php

namespace Modules\EntityAttribute\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\EntityAttribute\Enums\AttributeType;
use Modules\User\Models\User;

class CreateAttribute extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:attributes,name',
            'type' => ['required', Rule::enum(AttributeType::class)],
            'options' => ['required_if:type,select', 'array', 'min:1'],
            'options.*.label' => ['required', 'string', 'max:255', 'distinct'],
            'options.*.value' => ['required', 'string', 'max:255', 'lowercase', 'alpha_dash:ascii', 'distinct'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'name',
            'type' => 'type',
            'options' => 'options',
            'options.*.value' => 'value',
            'options.*.label' => 'label',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
