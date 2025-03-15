<?php

namespace Modules\EntityAttribute\Http\Resources;

use App\Http\Resources\DateTimeResource;
use App\Traits\WithPagination;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\EntityAttribute\Models\Attribute;

/**
 * @mixin Attribute
 */
class AttributeResource extends JsonResource
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
            'type' => $this->type,
            'options' => AttributeOptionResource::collection($this->attributeOptions),
            'createdAt' => DateTimeResource::make($this->created_at),
            'updatedAt' => DateTimeResource::make($this->updated_at),
        ];
    }
}
