<?php

namespace Modules\Project\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\EntityAttribute\Models\Attribute;
use Modules\Project\Enums\ProjectStatus;
use Modules\Project\Models\Project;
use Modules\Project\Rules\ValidAttributeValue;
use Modules\User\Models\User;

/**
 * @property Attribute $attribute
 * @property Project $project
 */
class UpdateProject extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:255|unique:projects,name,'.$this->project->id,
            'status' => ['nullable', Rule::enum(ProjectStatus::class)],
            'attributes' => ['sometimes', 'array', 'min:1', new ValidAttributeValue],
            'attributes.*.attribute_id' => ['required', 'distinct', 'exists:attributes,id'],
            'attributes.*.value' => ['required', 'string', 'string', 'max:255'],
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'name',
            'status' => 'status',
            'attributes' => 'attributes',
            'attributes.*.attribute_id' => 'attribute id',
            'attributes.*.value' => 'attribute value',
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
