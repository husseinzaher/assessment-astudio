<?php

namespace Modules\Timesheet\Http\Resources;

use App\Http\Resources\DateResource;
use App\Http\Resources\DateTimeResource;
use App\Traits\WithPagination;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Timesheet\Models\Timesheet;

/**
 * @mixin Timesheet
 */
class TimesheetResource extends JsonResource
{
    use WithPagination;

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'task_name' => $this->task_name,
            'date' => DateResource::make($this->date),
            'hours' => $this->hours,
            'projectId' => $this->project_id,
            'userId' => $this->user_id,
            'createdAt' => DateTimeResource::make($this->created_at),
            'updatedAt' => DateTimeResource::make($this->updated_at),
        ];
    }
}
