<?php

use Illuminate\Support\Facades\Route;
use Modules\Timesheet\Http\Controllers\Api\TimesheetController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('timesheet', TimesheetController::class)->names('timesheet');
});
