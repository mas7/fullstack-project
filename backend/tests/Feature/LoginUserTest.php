<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_finds_login_route(): void
    {
        // Arrange
        $data = [
            'email'    => 'test@example.com',
            'password' => '12345678'
        ];

        $user = User::factory()->create($data);

        // Act
        $response = $this->postJson('/api/login', $data);

        // Assert
        $response->assertOk();
    }


    /** @test */
    public function it_login_user_successfully(): void
    {
        // Arrange
        $data = [
            'email'    => 'test@example.com',
            'password' => '12345678'
        ];

        $user = User::factory()->create($data);

        // Act
        $response = $this->postJson('/api/login', $data);

        // Assert
        $response->assertOk();

        $data = $response->json('data');

        unset($data['token']);

        $this->assertEquals([
            'id'    => $user->id,
            'name'  => $user->name,
            'email' => $user->email,
        ], $data);
    }
}
