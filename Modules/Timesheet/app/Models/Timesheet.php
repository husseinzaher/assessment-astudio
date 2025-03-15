<?php

namespace Modules\Timesheet\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Modules\Project\Models\Project;
use Modules\Timesheet\Database\Factories\TimesheetFactory;
use Modules\User\Models\User;

/**
 * @property int $id
 * @property string $task_name
 * @property string $date
 * @property float $hours
 * @property int $project_id
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property User $user
 * @property Project $project
 */
class Timesheet extends BaseModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'task_name',
        'date',
        'hours',
        'project_id',
        'user_id',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    protected static function newFactory(): TimesheetFactory
    {
        return TimesheetFactory::new();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
