<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_finds_logout_route(): void
    {
        // Arrange
        $user = User::factory()->create();
        $user->createToken('api-token')->plainTextToken;

        // Act
        $this->actingAs($user);
        $response = $this->postJson('/api/logout');

        // Assert
        $response->assertOk();
    }

    /** @test */
    public function it_logout_user(): void
    {
        // Arrange
        $user = User::factory()->create();
        $user->createToken('api-token')->plainTextToken;

        // Act
        $this->actingAs($user);
        $this->postJson('/api/logout');

        // Assert
        $this->assertDatabaseEmpty('personal_access_tokens');
    }
}
