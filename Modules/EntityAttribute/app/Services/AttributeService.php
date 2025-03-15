<?php

namespace Modules\EntityAttribute\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Modules\EntityAttribute\Enums\AttributeType;
use Modules\EntityAttribute\Models\Attribute;
use Throwable;

class AttributeService
{
    public function collection(): \Illuminate\Support\Collection
    {
        return Attribute::get();
    }

    /**
     * @throws Throwable
     */
    public function create(array $data): Attribute
    {

        return DB::transaction(function () use ($data) {

            $options = Arr::pull($data, 'options');

            /** @var Attribute $attribute */
            $attribute = Attribute::create($data);
            if ($options && $attribute->type === AttributeType::Select) {
                $attribute->attributeOptions()->createMany($options);
            }

            return $attribute;
        });
    }

    /**
     * @throws Throwable
     */
    public function update(Attribute $attribute, array $data): Attribute
    {
        return DB::transaction(function () use ($attribute, $data) {
            $options = Arr::pull($data, 'options');
            $attribute->update($data);

            if ($options && $attribute->type === AttributeType::Select) {

                data_fill($options, '*.attribute_id', $attribute->id);

                $attribute->attributeOptions()->whereNotIn('value', Arr::pluck($options, 'value'))->delete();

                $attribute->attributeOptions()->upsert($options, ['attribute_id', 'value'], ['label']);

            }

            return $attribute;
        });
    }

    /**
     * @throws Throwable
     */
    public function delete(Attribute $attribute): ?bool
    {
        return $attribute->deleteOrFail();
    }
}
