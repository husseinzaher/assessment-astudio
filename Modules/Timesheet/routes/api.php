<?php

use Illuminate\Support\Facades\Route;
use Modules\Timesheet\Http\Controllers\Api\TimesheetController;

Route::middleware(\App\Enums\Guard::User->middleware())
    ->group(function () {
        Route::apiResource('timesheets', TimesheetController::class)->names('timesheets');
    });
