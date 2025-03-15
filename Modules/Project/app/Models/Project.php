<?php

namespace Modules\Project\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Modules\EntityAttribute\Models\AttributeValue;
use Modules\Project\Database\Factories\ProjectFactory;
use Modules\Project\Enums\ProjectStatus;
use Modules\Timesheet\Models\Timesheet;
use Modules\User\Models\User;
use function PHPUnit\Framework\isFalse;

/**
 * @property int $id
 * @property string $name
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property BelongsToMany|User[] $users
 * @property MorphMany|AttributeValue[] $attributeValues
 * @property HasMany|Timesheet[] $timesheets
 * @method  Builder  filter(array $filters)
 */
class Project extends BaseModel
{
    use HasFactory;

    const EQUAL = 'equal';
    const GREATER_THAN = 'greater_than';
    const LOWER_THAN = 'lower_than';
    const LIKE = 'like';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name', 'status'
    ];

    protected $casts = [
        'status' => ProjectStatus::class,
    ];

    protected static function newFactory(): ProjectFactory
    {
        return ProjectFactory::new();
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, ProjectUser::class)->withTimestamps();
    }

    public function attributeValues(): MorphMany
    {
        return $this->morphMany(AttributeValue::class, 'attributable');
    }

    public function timesheets(): HasMany
    {
        return $this->hasMany(Timesheet::class);
    }

    public function scopeFilter(Builder $query, Request $request)
    {


        return $query->when($request->filters, function (Builder $query, array $filters) {

            foreach ($filters as $column => $value) {
                $clause = is_array($value) && isset($value['clause']) ? $value['clause'] : static::EQUAL;
                $value = is_array($value) && isset($value['value']) ? $value['value'] : $value;

                $query->when(in_array($column, $this->fillable), function (Builder $query) use ($value, $clause, $column) {
                    $this->applyClause($query, $column, $clause, $value);
                });


                $query->when(!in_array($column, $this->fillable), function (Builder $query) use ($value, $clause, $column) {
                    $query->whereHas('attributeValues', function (Builder $query) use ($clause, $column, $value) {
                        $query->whereHas('attribute', function ($attrQuery) use ($column) {
                            $attrQuery->where('name', $column);
                        });
                        $this->applyClause($query, 'value', $clause, $value);
                    });
                });

            }

        });
    }

    protected function applyClause(Builder $query, string $column, string $clause, string $value): Builder
    {
        $operator = match ($clause) {
            static::GREATER_THAN => '>',
            static::LOWER_THAN => '<',
            static::LIKE => 'like',
            default => '='
        };

        if ($operator === 'like') {
            $value = "%{$value}%";
        }

        $isValidDateFormat = $this->isValidDateFormat($value);

        return $query->when($isValidDateFormat, function (Builder $query) use ($column, $operator, $value) {
            $query->whereDate($column, $operator, $value);
        })->when(!$isValidDateFormat, function (Builder $query) use ($column, $operator, $value) {
            $query->where($column, $operator, $value);
        });
    }

    function isValidDateFormat($date, $format = 'Y-m-d'): bool
    {

        try {
            $parsedDate = \Carbon\Carbon::createFromFormat($format, $date);
            return $parsedDate && $parsedDate->format($format) === $date;
        } catch (\Exception $e) {
            return false;

        }
    }

}
