<?php

namespace Tests\Feature;

use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_retrieves_all_projects(): void
    {
        // Arrange
        $user     = User::factory()->create();
        $projects = Project::factory(3)->create(['user_id' => $user->id]);

        // Act
        $this->actingAs($user);
        $response = $this->getJson('/api/projects');

        // Assert
        $data = $response->json('data.data');
        $this->assertEquals(ProjectResource::make($projects->first())->resolve(), $data[0]);
    }

    /** @test */
    public function it_creates_new_project(): void
    {
        // Arrange
        $user = User::factory()->create();
        $data = Project::factory()->make(['user_id' => $user->id])->toArray();

        // Act
        $this->actingAs($user);
        $this->postJson('/api/projects', $data);

        // Assert
        $this->assertDatabaseHas('projects', $data);
    }

    /** @test */
    public function it_gets_project_with_id(): void
    {
        // Arrange
        $user    = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);

        // Act
        $this->actingAs($user);
        $response = $this->getJson("/api/projects/{$project->id}");

        // Assert
        $data = $response->json('data');
        $this->assertEquals(ProjectResource::make($project)->resolve(), $data);
    }

    /** @test */
    public function it_updates_existing_project(): void
    {
        // Arrange
        $user    = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);
        $data    = ['name' => 'New Project Name'];

        // Act
        $this->actingAs($user);
        $this->putJson("/api/projects/{$project->id}", $data);

        // Assert
        $this->assertDatabaseHas('projects', $data);
    }

    /** @test */
    public function it_deletes_project(): void
    {
        // Arrange
        $user    = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);

        // Act
        $this->actingAs($user);
        $this->delete("/api/projects/{$project->id}");

        // Assert
        $this->assertDatabaseMissing('projects', $project->toArray());
    }
}
