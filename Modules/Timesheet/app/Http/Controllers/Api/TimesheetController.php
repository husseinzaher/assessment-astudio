<?php

namespace Modules\Timesheet\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Modules\Timesheet\Http\Requests\CreateTimesheet;
use Modules\Timesheet\Http\Requests\UpdateTimesheet;
use Modules\Timesheet\Http\Resources\TimesheetResource;
use Modules\Timesheet\Models\Timesheet;
use Modules\Timesheet\Services\TimesheetService;

class TimesheetController extends ApiController
{
    public function __construct(private readonly TimesheetService $timesheetService) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return self::apiBody([
            'timesheets' => TimesheetResource::paginate($this->timesheetService->paginate()),
        ])->apiResponse();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTimesheet $createTimesheet)
    {
        $timesheet = $this->timesheetService->create($createTimesheet->validated());

        return self::apiBody([
            'timesheet' => TimesheetResource::make($timesheet),
        ])->apiResponse();
    }

    /**
     * Show the specified resource.
     */
    public function show(Timesheet $timesheet)
    {
        return self::apiBody([
            'timesheet' => TimesheetResource::make($timesheet),
        ])->apiResponse();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTimesheet $updateTimesheet, Timesheet $timesheet)
    {
        $this->timesheetService->update($timesheet, $updateTimesheet->validated());

        return self::apiMessage('Timesheet updated')->apiBody([
            'timesheet' => TimesheetResource::make($timesheet),
        ])->apiResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Timesheet $timesheet)
    {
        $this->timesheetService->delete($timesheet);

        return self::apiMessage('Timesheet deleted')->apiResponse();
    }
}
