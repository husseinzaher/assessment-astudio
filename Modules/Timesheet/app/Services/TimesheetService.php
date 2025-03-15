<?php

namespace Modules\Timesheet\Services;

use Modules\Timesheet\Models\Timesheet;

class TimesheetService
{
    public function paginate(): \Illuminate\Pagination\LengthAwarePaginator
    {
        return Timesheet::paginate();
    }

    public function create(array $data): Timesheet
    {

        return Timesheet::create([
            'user_id' => auth()->user()->id,
            ...$data
        ]);
    }

    public function update(Timesheet $timesheet, array $data): Timesheet
    {
        $timesheet->update([
            'user_id' => auth()->user()->id,
            ...$data
        ]);

        return $timesheet;
    }

    public function delete(Timesheet $timesheet): void
    {
        $timesheet->delete();
    }
}
