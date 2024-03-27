<?php

namespace App\Http\Controllers;

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
     */
    public function index(): JsonResponse
    {
        $projects = $this->projectService->getAllProjects();

        return response()->json([
            'message' => 'Project created successfully',
            'data'    => new ProjectCollection($projects),
        ]);
    }

    /**
     * Store a newly created resource in storage.
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
     */
    public function destroy(Project $project): JsonResponse
    {
        $project->delete();

        return response()->json([
            'message' => 'Project deleted successfully'
        ]);
    }
}
