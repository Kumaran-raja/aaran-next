<?php

namespace Aaran\Core\User\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_render_the_users_index_page()
    {
        $response = $this->get(route('users.index'));
        $response->assertStatus(200);
    }

    #[Test]
    public function it_can_create_a_new_user()
    {
        $response = $this->post(route('users.store'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect(route('users.index'));
        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
    }
}
