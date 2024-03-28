<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetAllProjectsRequest;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectCollection;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct(private ProjectService $projectService)
    {
        // 
    }

    /**
     * Display a listing of the resource.
     *
     * @param  GetAllProjectsRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(GetAllProjectsRequest $request): JsonResponse
    {
        $data = $request->validated();

        $projects = $this->projectService->getAllProjects($data);

        return response()->json([
            'message' => 'Projects retrieved successfully',
            'data'    => new ProjectCollection($projects),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreProjectRequest  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \ErrorException
     */
    public function store(StoreProjectRequest $request): JsonResponse
    {
        $data = $request->validated();

        $project = $this->projectService->createProject($data);

        return response()->json([
            'message' => 'Project created successfully',
            'data'    => ProjectResource::make($project),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Project  $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Project $project): JsonResponse
    {
        return response()->json([
            'message' => 'Project retrieved successfully',
            'data'    => ProjectResource::make($project),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateProjectRequest  $request
     * @param  Project  $project
     * @return \Illuminate\Http\JsonResponse
     * @throws \ErrorException
     */
    public function update(UpdateProjectRequest $request, Project $project): JsonResponse
    {
        $data = $request->validated();

        $project = $this->projectService->updateProject($data, $project);

        return response()->json([
            'message' => 'Project updated successfully',
            'data'    => ProjectResource::make($project),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Project  $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Project $project): JsonResponse
    {
        $project->delete();

        return response()->json([
            'message' => 'Project deleted successfully'
        ]);
    }
}
