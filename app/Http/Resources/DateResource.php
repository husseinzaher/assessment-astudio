<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

/**
 * @property Carbon $resource
 */
class DateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'timestamp' => $this->resource->unix(),
            'formatted' => $this->resource->translatedFormat('j F Y'),
            'date' => $this->resource->toDateString(),
        ];
    }
}
