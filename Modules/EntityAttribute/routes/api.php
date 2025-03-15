<?php

use Illuminate\Support\Facades\Route;
use Modules\EntityAttribute\Http\Controllers\Api\AttributeController;

Route::middleware([\App\Enums\Guard::User->middleware()])->group(function () {
    Route::apiResource('attributes', AttributeController::class)->names('entity-attributes');
});
