<?php


namespace App\BusinessLogic\Todos;


use App\DataAccess\ProjectsRepo;
use App\DataAccess\TodosRepo;
use Illuminate\Database\Eloquent\Collection;


class TodosBL
{
    private $todosRepo;
    private $projectsRepo;

    public function __construct(TodosRepo $todosRepo, ProjectsRepo $projectsRepo)
    {
        $this->todosRepo = $todosRepo;
        $this->projectsRepo = $projectsRepo;
    }

    public function listTodos(): Collection
    {
        return $this->todosRepo->listTodos();
    }

    /**
     * @param int $userId
     * @param int $projectId
     * @param string $description
     * @throws TodosException
     */
    public function createTodo(int $userId, int $projectId, string $description)
    {
        if (!$this->projectsRepo->projectIdExists($projectId)) {
            throw new TodosException(
                "Project id does not exist",
                TodosException::PROJECT_ID_DOES_NOT_EXIST
            );
        }
        elseif (!$this->todosRepo->createTodo($userId, $projectId, $description)) {
            throw new TodosException(
                "Could not create a TODO",
                TodosException::CANNOT_CREATE_TODO
            );
        }
    }

}
