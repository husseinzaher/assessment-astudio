<?php

namespace Modules\EntityAttribute\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\EntityAttribute\Database\Factories\AttributeOptionFactory;

/**
 * @property int $id
 * @property int $attribute_id
 * @property string $label
 * @property string $value
 */
class AttributeOption extends BaseModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['attribute_id', 'label', 'value'];

    protected static function newFactory(): AttributeOptionFactory
    {
        return AttributeOptionFactory::new();
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}
