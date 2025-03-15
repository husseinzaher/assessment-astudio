<?php

namespace Modules\Project\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Modules\Project\Models\Project;

class ProjectService
{
    public function paginate(Request $request): \Illuminate\Pagination\LengthAwarePaginator
    {
        $query = Project::filter($request);
        return $query->paginate();
    }

    /**
     * @throws \Throwable
     */
    public function create(array $data): Project
    {

        return DB::transaction(function () use ($data) {

            $attributes = Arr::pull($data, 'attributes');
            /** @var Project $project */
            $project = Project::create($data);

            if ($attributes) {
                $project->attributeValues()->createMany($attributes);
            }

            return $project;
        });
    }

    public function update(Project $project, array $data)
    {
        return DB::transaction(function () use ($data, $project) {
            $attributes = Arr::pull($data, 'attributes');

            $project->update($data);

            if ($attributes) {

                data_fill($attributes, '*.attributable_id', $project->id);
                data_fill($attributes, '*.attributable_type', $project->getMorphClass());
                $project->attributeValues()->whereNotIn('value', Arr::pluck($attributes, 'value'))->delete();
                $project->attributeValues()->upsert($attributes, ['attributable_id', 'attributable_type', 'attribute_id'], ['value']);

            }

            return $project;
        });
    }

    public function delete(Project $project): void
    {
        $project->attributeValues()->delete();
        $project->timesheets()->delete();
        $project->delete();
    }
}
