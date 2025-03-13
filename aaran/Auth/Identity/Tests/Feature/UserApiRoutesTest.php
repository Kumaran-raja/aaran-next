<?php


namespace Aaran\Auth\Identity\Tests\Feature;

use Aaran\Auth\Identity\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserApiRoutesTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

//    #[Test]
//    public function unauthenticated_user_cannot_access_api_users()
//    {
//        $this->json('GET', route('api.users.index'))
//            ->assertStatus(401);
//    }
//
//    #[Test]
//    public function authenticated_user_can_get_all_users()
//    {
//        Sanctum::actingAs($this->user);
//
//        $this->json('GET', route('api.users.index'))
//            ->assertStatus(200)
//            ->assertJsonStructure([
//                'data' => [['id', 'name', 'email']]
//            ]);
//    }
//
//    #[Test]
//    public function unauthenticated_user_cannot_update_a_user()
//    {
//        $this->json('PUT', route('api.users.update', $this->user->id), [
//            'name' => 'Hacker Name'
//        ])->assertStatus(401);
//    }
//
//    #[Test]
//    public function authenticated_user_can_update_a_user()
//    {
//        Sanctum::actingAs($this->user);
//
//        $this->json('PUT', route('api.users.update', $this->user->id), [
//            'name' => 'Updated Name'
//        ])->assertStatus(200);
//
//        $this->assertDatabaseHas('users', [
//            'id' => $this->user->id,
//            'name' => 'Updated Name'
//        ]);
//    }
}
