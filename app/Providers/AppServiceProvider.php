<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Laravel\Passport\Passport;
use Modules\Project\Models\Project;
use Modules\User\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Passport::hashClientSecrets();
        $this->morphMap();
        $this->setDefaultPasswordRules();
    }

    protected function setDefaultPasswordRules(): void
    {
        Password::defaults(Password::min(8)->max(20)->mixedCase());
    }

    protected function morphMap(): void
    {
        Relation::enforceMorphMap([
            'User' => User::class,
            'Project' => Project::class,
        ]);
    }
}
