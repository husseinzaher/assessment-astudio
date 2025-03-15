<?php

namespace Modules\Project\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Modules\Project\Http\Requests\CreateProject;
use Modules\Project\Http\Requests\UpdateProject;
use Modules\Project\Http\Resources\ProjectResource;
use Modules\Project\Models\Project;
use Modules\Project\Services\ProjectService;
use Throwable;

class ProjectController extends ApiController
{
    public function __construct(private readonly ProjectService $projectService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return self::apiBody([
            'projects' => ProjectResource::paginate($this->projectService->paginate($request)),
        ])->apiResponse();
    }

    /**
     * Store a newly created resource in storage.
     * @throws Throwable
     */
    public function store(CreateProject $createProject)
    {
        $project = $this->projectService->create($createProject->validated());

        return self::apiBody([
            'project' => ProjectResource::make($project),
        ])->apiResponse();
    }

    /**
     * Show the specified resource.
     */
    public function show(Project $project)
    {
        return self::apiBody([
            'project' => ProjectResource::make($project),
        ])->apiResponse();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProject $updateProject, Project $project)
    {

        $this->projectService->update($project, $updateProject->validated());

        return self::apiBody([
            'project' => ProjectResource::make($project),
        ])->apiResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $this->projectService->delete($project);

        return self::apiMessage('Project deleted')->apiResponse();
    }
}
