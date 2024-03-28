<?php

namespace App\Services;

use App\Models\Project;
use ErrorException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class ProjectService
{
    /**
     * Retrieve all projects.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllProjects(array $data): LengthAwarePaginator
    {
        $projects = Project::query()
            ->with(['user'])
            ->owner()
            ->orderByDesc('created_at')
            ->paginate(data_get($data, 'limit', 10));

        return $projects;
    }

    /**
     * Create a new project.
     *
     * @param  array  $data
     * @return \App\Models\Project
     * @throws \ErrorException
     */
    public function createProject(array $data): Project
    {
        try {
            $data['user_id'] = auth()->id();

            $project = Project::create($data);

            return $project;
        } catch (\Throwable $th) {
            Log::error($th);

            throw new ErrorException('Something went wrong while processing your request. Please contact support.');
        }
    }

    /**
     * Update an existing project.
     *
     * @param  array  $data
     * @param  \App\Models\Project  $project
     * @return \App\Models\Project
     * @throws \ErrorException
     */
    public function updateProject(array $data, Project $project): Project
    {
        try {
            $project->update($data);

            return $project;
        } catch (\Throwable $th) {
            Log::error($th);

            throw new ErrorException('Something went wrong while processing your request. Please contact support.');
        }
    }
}
