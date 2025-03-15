<?php

namespace Modules\EntityAttribute\Http\Resources;

use App\Traits\WithPagination;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\EntityAttribute\Models\AttributeValue;

/**
 * @mixin AttributeValue
 */
class AttributeValueResource extends JsonResource
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
            'attribute' => [
                'id' => $this->attribute->id,
                'name' => $this->attribute->name,
                'type' => $this->attribute->type,
            ],
            'value' => $this->value,
        ];
    }
}
