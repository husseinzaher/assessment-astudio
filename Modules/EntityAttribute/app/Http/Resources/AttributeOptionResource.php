<?php

namespace Modules\EntityAttribute\Http\Resources;

use App\Traits\WithPagination;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\EntityAttribute\Models\AttributeOption;

/**
 * @mixin AttributeOption
 */
class AttributeOptionResource extends JsonResource
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
            'label' => $this->label,
            'value' => $this->value,
        ];
    }
}
