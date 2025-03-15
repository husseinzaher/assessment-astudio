<?php

namespace Modules\EntityAttribute\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Modules\EntityAttribute\Http\Requests\CreateAttribute;
use Modules\EntityAttribute\Http\Requests\UpdateAttribute;
use Modules\EntityAttribute\Http\Resources\AttributeResource;
use Modules\EntityAttribute\Models\Attribute;
use Modules\EntityAttribute\Services\AttributeService;
use Throwable;

class AttributeController extends ApiController
{
    public function __construct(private readonly AttributeService $attributeService) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attributes = $this->attributeService->collection();

        return self::apiBody([
            'attributes' => AttributeResource::collection($attributes),
        ])->apiResponse();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @throws Throwable
     */
    public function store(CreateAttribute $createAttribute)
    {

        $attribute = $this->attributeService->create($createAttribute->validated());

        return self::apiBody([
            'attribute' => AttributeResource::make($attribute),
        ])->apiResponse();
    }

    /**
     * Update the specified resource in storage.
     *
     * @throws Throwable
     */
    public function update(UpdateAttribute $updateAttribute, Attribute $attribute)
    {

        $attribute = $this->attributeService->update($attribute, $updateAttribute->validated());

        return self::apiBody([
            'attribute' => AttributeResource::make($attribute),
        ])->apiResponse();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws Throwable
     */
    public function destroy(Attribute $attribute)
    {

        $this->attributeService->delete($attribute);

        return self::apiResponse();
    }
}
