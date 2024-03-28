<?php

namespace App\Services;

use App\Http\Resources\ProjectResource;
use App\Models\Project;
use ErrorException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class ProjectService
{
    public function getAllProjects(array $data): LengthAwarePaginator
    {
        $projects = Project::query()
            ->with(['user'])
            ->owner()
            ->orderByDesc('created_at')
            ->paginate(data_get($data, 'limit', 10));

        return $projects;
    }

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
