<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_finds_register_route(): void
    {
        // Arrange
        $data = [
            'name'                  => 'Mohamed',
            'email'                 => 'mohamed@gmail.com',
            'password'              => '12345678',
            'password_confirmation' => '12345678',
        ];

        // Act
        $response = $this->postJson('/api/register', $data);

        // Assert
        $response->assertOk();
    }

    /** @test */
    public function it_register_new_user(): void
    {
        // Arrange
        $data = [
            'name'                  => 'Mohamed',
            'email'                 => 'mohamed@gmail.com',
            'password'              => '12345678',
            'password_confirmation' => '12345678',
        ];

        // Act
        $this->postJson('/api/register', $data);

        // Assert
        $this->assertDatabaseHas('users', [
            'name'  => $data['name'],
            'email' => $data['email'],
        ]);
    }
}
