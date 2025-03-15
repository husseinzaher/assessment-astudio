<?php

namespace Modules\EntityAttribute\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\EntityAttribute\Database\Factories\AttributeValueFactory;

/**
 * @property int $id
 * @property string $value
 * @property int $attribute_id
 * @property int $attributable_id
 * @property string $attributable_type
 * @property Attribute $attribute
 * @property AttributeOption $attributeOption
 */
class AttributeValue extends BaseModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['attributable_id', 'attributable_type', 'attribute_id', 'value'];

    protected static function newFactory(): AttributeValueFactory
    {
        return AttributeValueFactory::new();
    }

    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }

    public function attributeOption(): BelongsTo
    {
        return $this->belongsTo(AttributeOption::class, 'value', 'value');
    }
}
