<?php

use Illuminate\Support\Facades\Route;
use Modules\Project\Http\Controllers\Api\ProjectController;

Route::middleware([\App\Enums\Guard::User->middleware()])
    ->group(function () {
        Route::apiResource('projects', ProjectController::class)->names('project');
    });
