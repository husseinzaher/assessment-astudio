<?php

namespace Modules\Timesheet\Tests\Feature;

use App\Enums\Guard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Modules\Timesheet\Models\Timesheet;
use Modules\Project\Models\Project;
use Modules\User\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TimesheetTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();

        Passport::actingAs($user, guard: Guard::User->value);
    }

    #[Test]
    public function it_can_create_a_timesheet()
    {
        $project = Project::factory()->create();
        $user = User::factory()->create();
        $data = [
            'task_name' => 'Develop API',
            'date' => now()->toDateString(),
            'hours' => 4.5,
            'project_id' => $project->id,
            'user_id' => $user->id,
        ];

        $response = $this->postJson('/api/timesheets', $data);

        $response->assertStatus(200)->assertJsonStructure([
            'status', 'message', 'body' => ['timesheet' => ['id', 'task_name', 'date', 'hours', 'projectId', 'userId']]
        ]);
    }

    #[Test]
    public function it_can_update_a_timesheet()
    {
        $timesheet = Timesheet::factory()->create();
        $data = ['task_name' => 'Updated Task'];

        $response = $this->putJson("/api/timesheets/{$timesheet->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('timesheets', ['id' => $timesheet->id, 'task_name' => 'Updated Task']);
    }

    #[Test]
    public function it_can_delete_a_timesheet()
    {
        $timesheet = Timesheet::factory()->create();

        $response = $this->deleteJson("/api/timesheets/{$timesheet->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('timesheets', ['id' => $timesheet->id]);
    }

    #[Test]
    public function it_can_list_timesheets()
    {
        Timesheet::factory()->count(3)->create();

        $response = $this->getJson('/api/timesheets');

        $response->assertStatus(200)->assertJsonStructure([
            'status', 'message', 'body' => ['timesheets' => [
                'data' => [
                    ['id', 'task_name', 'date', 'hours', 'projectId', 'userId']
                ],
                'paginate' => [
                    'links', 'count', 'total', "count", "total", "perPage",
                    "nextPageUrl", "prevPageUrl", "currentPage", "lastPage",
                    "firstItem", "hasPages", "hasMorePages", "lastItem",
                    "firstPageUrl", "from", "lastPageUrl", "links", "path", "to"
                ]
            ]
            ]
        ]);
    }

    #[Test]
    public function it_validates_timesheet_creation()
    {
        $response = $this->postJson('/api/timesheets', []);

        $response->assertStatus(422)->assertJsonValidationErrors(['task_name', 'date', 'hours', 'project_id', 'user_id']);
    }
}
