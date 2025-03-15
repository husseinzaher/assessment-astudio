<?php

namespace Modules\EntityAttribute\Models;

use App\Models\BaseModel;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Modules\EntityAttribute\Database\Factories\AttributeFactory;
use Modules\EntityAttribute\Enums\AttributeType;

/**
 * @mixin Builder
 *
 * @property int $id
 * @property string $name
 * @property AttributeType $type
 * @property AttributeValue[] $attributeValues
 * @property AttributeOption[] $attributeOptions
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Attribute extends BaseModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['name', 'type'];

    protected $casts = [
        'type' => AttributeType::class,
    ];

    protected static function newFactory(): AttributeFactory
    {
        return AttributeFactory::new();
    }

    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class);
    }

    public function attributeOptions(): HasMany
    {
        return $this->hasMany(AttributeOption::class);
    }
}
