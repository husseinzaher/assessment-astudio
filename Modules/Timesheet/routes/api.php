<?php

use Illuminate\Support\Facades\Route;
use Modules\Timesheet\Http\Controllers\Api\TimesheetController;

Route::bind('timesheet', function ($value) {
    return \Modules\Timesheet\Models\Timesheet::where('id', $value)
        ->where('user_id', auth()->id())
        ->firstOrFail();
});

Route::middleware(\App\Enums\Guard::User->middleware())
    ->group(function () {
        Route::apiResource('timesheets', TimesheetController::class)->names('timesheets');
    });
