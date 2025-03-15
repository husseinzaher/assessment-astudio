<?php

namespace Modules\Project\Http\Resources;

use App\Http\Resources\DateTimeResource;
use App\Traits\WithPagination;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\EntityAttribute\Http\Resources\AttributeValueResource;
use Modules\Project\Models\Project;

/**
 * @mixin Project
 */
class ProjectResource extends JsonResource
{
    use WithPagination;

    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'attributes' => AttributeValueResource::collection($this->attributeValues),
            'createdAt' => DateTimeResource::make($this->created_at),
            'updatedAt' => DateTimeResource::make($this->updated_at),
        ];
    }
}
