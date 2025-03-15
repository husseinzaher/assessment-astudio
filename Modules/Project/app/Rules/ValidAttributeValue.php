<?php

namespace Modules\Project\Rules;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Modules\EntityAttribute\Enums\AttributeType;
use Modules\EntityAttribute\Models\Attribute;

class ValidAttributeValue implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        $attributes = Attribute::with('attributeOptions')->get();

        collect($value)->each(function ($attributeFromRequest) use ($attributes, $fail) {

            $attributes->where('id', data_get($attributeFromRequest, 'attribute_id'))
                ->each(function (Attribute $attribute) use ($attributeFromRequest, $fail) {

                    $this->checkDataType($attribute, data_get($attributeFromRequest, 'value'), $fail);

                    if ($attribute->type == AttributeType::Select) {
                        if (!$attribute->attributeOptions()->where('value', data_get($attributeFromRequest, 'value'))->exists()) {
                            $fail("The selected value for {$attribute->name} is invalid.");
                        }
                    }
                });

        });
    }

    private function checkDataType(Attribute $attribute, $value, Closure $fail): void
    {
        match ($attribute->type) {
            AttributeType::Text => is_string($value) ? true : $fail("The value for {$attribute->name} must be a string."),
            AttributeType::Number => is_numeric($value) ? true : $fail("The value for {$attribute->name} must be a number."),
            AttributeType::Date => $this->isValidDateFormat($value) ? true : $fail("The value for {$attribute->name} must be a date."),
            default => true
        };
    }

    function isValidDateFormat($date, $format = 'Y-m-d'): bool
    {
        return Carbon::createFromFormat($format, $date) !== false;
    }
}
