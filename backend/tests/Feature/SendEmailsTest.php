<?php

namespace Tests\Feature;

use App\Jobs\SendEmailsJob;
use App\Mail\UserWelcomeMail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class SendEmailsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_finds_send_emails_route(): void
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $this->actingAs($user);
        $response = $this->postJson('/api/users/send-emails');

        // Assert
        $response->assertOk();
    }

    /** @test */
    public function it_dispatches_send_emails_job(): void
    {
        // Arrange
        $user = User::factory()->create();
        Queue::fake();

        // Act
        $this->actingAs($user);
        $this->postJson('/api/users/send-emails');

        // Assert
        Queue::assertPushed(SendEmailsJob::class);
    }

    /** @test */
    public function it_sends_email_to_users(): void
    {
        // Arrange
        Mail::fake();
        $user = User::factory()->create();

        // Act
        $this->actingAs($user);
        $this->postJson('/api/users/send-emails');

        // Assert
        Mail::assertSent(UserWelcomeMail::class);
    }
}
