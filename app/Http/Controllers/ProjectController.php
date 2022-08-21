<?php

namespace App\Http\Controllers;

use App\BusinessLogic\Projects\ProjectsBL;
use App\BusinessLogic\Projects\ProjectsException;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response as ResponseFacade;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{

    private ProjectsBL $projectsBl;
    public function __construct(ProjectsBL $projectsBl)
    {
        $this->projectsBl = $projectsBl;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response | JsonResponse
     */
    public function index()
    {
        return ResponseFacade::json($this->projectsBl->listProjects());
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
     * @param  \App\Http\Requests\StoreProjectRequest  $request
     * @return \Illuminate\Http\Response | JsonResponse
     */
    public function store(StoreProjectRequest $request)
    {
        try {
            $this->projectsBl->createProject($request->json('name'));
            return ResponseFacade::json(["success" => true]);
        }
        catch (ProjectsException $e) {
            return ResponseFacade::json([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response | JsonResponse
     */
    public function show(Project $project)
    {
        return ResponseFacade::json($project);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProjectRequest  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        //
    }
}
