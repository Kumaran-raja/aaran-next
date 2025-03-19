<?php


namespace Aaran\Core\User\Tests\Feature;

use Aaran\Core\User\Models\User;
use Aaran\Core\User\Notifications\MfaOtpNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MfaControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_sends_mfa_otp_when_mfa_is_enabled()
    {
        Notification::fake();

        $user = User::factory()->create([
            'mfa_enabled' => true,
            'mfa_method' => 'email',
        ]);

        $this->actingAs($user)
            ->getJson('/mfa/trigger')
            ->assertStatus(200)
            ->assertJson(['message' => 'OTP sent via email']);

        Notification::assertSentTo($user, MfaOtpNotification::class);
    }

    #[Test]
    public function it_does_not_send_otp_if_mfa_is_not_enabled()
    {
        $user = User::factory()->create([
            'mfa_enabled' => false,
        ]);

        $this->actingAs($user)
            ->getJson('/mfa/trigger')
            ->assertStatus(400)
            ->assertJson(['error' => 'MFA not required']);
    }

    #[Test]
    public function it_verifies_mfa_successfully_with_correct_otp()
    {
        $user = User::factory()->create([
            'mfa_enabled' => true,
        ]);

        Cache::put("mfa_otp_{$user->id}", '123456', 300);

        $response = $this->actingAs($user)
            ->postJson('/mfa/verify', ['otp' => '123456']);

        $response->assertStatus(200)
            ->assertJson(['message' => 'MFA verification successful']);

        $this->assertNull(Cache::get("mfa_otp_{$user->id}"));
    }

    #[Test]
    public function it_fails_mfa_verification_with_invalid_otp()
    {
        $user = User::factory()->create([
            'mfa_enabled' => true,
        ]);

        Cache::put("mfa_otp_{$user->id}", '123456', 300);

        $response = $this->actingAs($user)
            ->postJson('/mfa/verify', ['otp' => '654321']);

        $response->assertStatus(401)
            ->assertJson(['error' => 'Invalid OTP']);
    }

    #[Test]
    public function it_allows_users_to_enable_mfa()
    {
        $user = User::factory()->create([
            'mfa_enabled' => false,
        ]);

        $this->actingAs($user)
            ->postJson('/mfa/enable', ['method' => 'email'])
            ->assertStatus(200)
            ->assertJson(['message' => 'MFA enabled successfully']);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'mfa_enabled' => true,
            'mfa_method' => 'email'
        ]);
    }
}
