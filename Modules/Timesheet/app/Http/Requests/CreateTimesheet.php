<?php

namespace Modules\Timesheet\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\User\Models\User;

class CreateTimesheet extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'task_name' => 'required|string|max:255',
            'date' => 'required|date',
            'hours' => 'required|numeric|min:0|max:500|decimal:0,2',
            'user_id' => 'required|exists:users,id',
            'project_id' => 'required|exists:projects,id',
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
