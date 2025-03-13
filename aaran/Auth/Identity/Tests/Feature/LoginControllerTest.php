<?php


namespace Aaran\Auth\Identity\Tests\Feature;

use Aaran\Auth\Identity\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling(); // Show detailed errors
        $this->withoutMiddleware(\Illuminate\Session\Middleware\StartSession::class); // Ensure sessions are active
    }

    #[Test]
    public function it_allows_user_to_login_with_valid_credentials()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);


        $response->assertStatus(200)
            ->assertJson(['message' => 'Login successful']);
//
        $this->assertAuthenticatedAs($user);


        $this->assertAuthenticated();
//        $response->assertRedirect(route('dashboard', absolute: false));
    }

    #[Test]
    public function it_denies_login_with_invalid_credentials()
    {
        $user = User::factory()->create();

        $response = $this->postJson('/login', [
            'email' => $user->email,
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure(['error']);

        $this->assertGuest();
    }

    #[Test]
    public function it_requires_mfa_for_users_with_mfa_enabled()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
            'mfa_enabled' => true
        ]);

        $response = $this->postJson('/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertStatus(401)
            ->assertJson(['message' => 'MFA required']);
    }

    #[Test]
    public function it_logs_out_authenticated_users()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->postJson('/logout')
            ->assertStatus(200)
            ->assertJson(['message' => 'Logged out successfully']);

        $this->assertGuest();
    }
}
