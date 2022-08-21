<?php

namespace App\Http\Controllers;

use App\BusinessLogic\Todos\TodosBL;
use App\BusinessLogic\Todos\TodosException;
use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Models\Todo;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response as ResponseFacade;

class TodoController extends Controller
{
    private $todosBL;
    public function __construct(TodosBL $todosBL)
    {
        $this->todosBL = $todosBL;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response | JsonResponse
     */
    public function index()
    {
        return ResponseFacade::json($this->todosBL->listTodos());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTodoRequest  $request
     * @return \Illuminate\Http\Response | JsonResponse
     */
    public function store(StoreTodoRequest $request)
    {
        $json = $request->json()->all();
        try {
            $this->todosBL->createTodo(
                Auth::id(),
                $json['project_id'],
                $json['description']
            );
            return ResponseFacade::json(["success" => true]);
        }
        catch (TodosException $e) {
            return ResponseFacade::json([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function edit(Todo $todo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTodoRequest  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response | JsonResponse
     */
    public function update(UpdateTodoRequest $request, Todo $todo)
    {
        if ($todo->update([
            'is_done' => $request->json()->all()['is_done']
        ]))
        {
            return ResponseFacade::json([
                "success" => true
            ]);
        }
        else {
            return ResponseFacade::json([
                "success" => false,
                "message" => "Could not update is_done"
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response | JsonResponse
     */
    public function destroy(Todo $todo)
    {
        $result = $todo->delete();
        if (is_null($result) || true === $result) {
            return ResponseFacade::json([
                "success" => true
            ]);
        }
        else {
            return ResponseFacade::json([
                "success" => true,
                "message" => "Could not delete a todo item"
            ]);
        }
    }
}
