<?php


namespace App\BusinessLogic\Projects;


use App\DataAccess\ProjectsRepo;
use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

class ProjectsBL
{

    private ProjectsRepo $projectsRepo;
    public function __construct(ProjectsRepo $projectsRepo)
    {
        $this->projectsRepo = $projectsRepo;
    }

    /**
     * @return Collection<Project>
     */
    public function listProjects(): Collection
    {
        return $this->projectsRepo->listProjects();
    }

    /**
     * @param string $projectName
     * @throws ProjectsException
     */
    public function createProject(string $projectName): void
    {
        if ($this->projectsRepo->projectNameExists($projectName)) {
            throw new ProjectsException(
                "A project with this name already exists",
                ProjectsException::DUPLICATE_PROJECT_NAME
            );
        }
        elseif (!$this->projectsRepo->createProject($projectName)) {
            throw new ProjectsException(
                "Could not create project",
                ProjectsException::CANNOT_CREATE_PROJECT
            );
        }
    }
}
