<?php

use Illuminate\Support\Facades\Route;
use Modules\Project\Http\Controllers\Api\ProjectController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('project', ProjectController::class)->names('project');
});
