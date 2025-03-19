<?php

namespace Aaran\Core\User\Tests\Unit;

use Aaran\Core\User\Models\User;
use Aaran\Core\User\Repositories\UserRepository;
use Aaran\Core\User\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    protected UserRepository $userRepository;
    protected UserService $userService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository = Mockery::mock(UserRepository::class);
        $this->userService = new UserService($this->userRepository);
    }

    #[Test]
    public function it_can_register_a_user()
    {
        $this->userRepository->shouldReceive('create')->once()->andReturn(
            new User(['name' => 'John Doe', 'email' => 'john@example.com'])
        );

        $user = $this->userService->registerUser([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'secret123',
        ]);

        $this->assertEquals('John Doe', $user->name);
        $this->assertEquals('john@example.com', $user->email);
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}

