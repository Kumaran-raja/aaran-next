<?php

namespace Aaran\Auth\Identity\Tests\Feature;

use Tests\TestCase;
use Aaran\Auth\Identity\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class UserWebRoutesTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

//    #[Test]
//    public function guest_cannot_access_user_index()
//    {
//        $this->actingAs($this->user)
//            ->get(route('users.index'))
//            ->assertStatus(200);
//    }

//    #[Test]
//    public function authenticated_user_can_access_user_index()
//    {
//        $this->actingAs($this->user)
//            ->get(route('users.index'))
//            ->assertStatus(200)
//            ->assertViewIs('users.index');
//    }
//
//    #[Test]
//    public function guest_cannot_access_user_edit_page()
//    {
//        $this->get(route('users.edit', $this->user->id))
//            ->assertRedirect(route('login'));
//    }
//
//    #[Test]
//    public function authenticated_user_can_access_user_edit_page()
//    {
//        $this->actingAs($this->user)
//            ->get(route('users.edit', $this->user->id))
//            ->assertStatus(200)
//            ->assertViewIs('users.edit')
//            ->assertViewHas('user');
//    }
//
//    #[Test]
//    public function authenticated_user_can_update_a_user()
//    {
//        $newData = ['name' => 'Updated Name'];
//
//        $this->actingAs($this->user)
//            ->put(route('users.update', $this->user->id), $newData)
//            ->assertRedirect(route('users.index'));
//
//        $this->assertDatabaseHas('users', ['id' => $this->user->id, 'name' => 'Updated Name']);
//    }
}
