<?php

namespace Modules\User\Http\Resources;

use App\Http\Resources\DateTimeResource;
use App\Traits\WithPagination;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\User\Models\User;

/**
 * @mixin User
 */
class UserResource extends JsonResource
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
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'email' => $this->email,
            'createdAt' => DateTimeResource::make($this->created_at),
            'updatedAt' => DateTimeResource::make($this->updated_at),
        ];
    }
}
