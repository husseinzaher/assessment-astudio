<?php

namespace Modules\User\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;
use Laravel\Passport\HasApiTokens;
use Modules\Project\Models\Project;
use Modules\Project\Models\ProjectUser;
use Modules\Timesheet\Models\Timesheet;
use Modules\User\Database\Factories\UserFactory;

/**
 * @mixin Builder
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, ProjectUser::class)->withTimestamps();
    }

    public function timesheets(): HasMany
    {
        return $this->hasMany(Timesheet::class);
    }

    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }

    protected $hidden = [
        'password',
    ];
}
