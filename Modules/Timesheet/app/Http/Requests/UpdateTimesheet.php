<?php

namespace Modules\Timesheet\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\User\Models\User;

class UpdateTimesheet extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'task_name' => 'nullable|string|max:255',
            'date' => 'nullable|date',
            'hours' => 'nullable|numeric|decimal:0,2|min:0|max:500',
            'user_id' => 'nullable|exists:users,id',
            'project_id' => 'nullable|exists:projects,id',
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
