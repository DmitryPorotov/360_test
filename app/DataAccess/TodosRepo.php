<?php


namespace App\DataAccess;


use App\Models\Todo;
use Illuminate\Database\Eloquent\Collection;

class TodosRepo
{
    /**
     * @return Collection<Todo>
     */
    public function listTodos(): Collection
    {
        return Todo::all();
    }

    /**
     * @param int $projectId
     * @return Collection<Todo>
     */
    public function listTodosByProjectId(int $projectId): Collection
    {
        return Todo::query()->where('project_id', $projectId)->get();
    }

    /**
     * @param int $userId
     * @return Collection<Todo>
     */
    public function listTodosByUserId(int $userId): Collection
    {
        return Todo::query()->where('user_id', $userId)->get();
    }

    public function createTodo(int $userId, int $projectId, string $description)
    {
        $todo = new Todo();
        $todo->fill([
            'user_id' => $userId,
            'project_id' => $projectId,
            'description' => $description
        ]);
        return $todo->save();
    }

}
