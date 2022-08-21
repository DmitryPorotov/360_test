<?php


namespace App\DataAccess;


use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

class ProjectsRepo
{

    /**
     * @return Collection<Project>
     */
    public function listProjects(): Collection
    {
        return Project::all();
    }

    public function projectNameExists(string $projectName): bool
    {
        $c = Project::query()->where([
            'name' => $projectName
        ])->count();

        return $c > 0;
    }

    public function projectIdExists(int $projectId): bool
    {
        $q = Project::query()->where([
            'id' => $projectId
        ])
        ->whereNull('deleted_at');
        $c = $q->count();

        return $c > 0;
    }

    public function createProject(string $projectName): bool
    {
        $project = new Project();
        $project->fill([
            'name' => $projectName
        ]);
        return $project->save();
    }
}
