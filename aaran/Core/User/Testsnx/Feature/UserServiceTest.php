<?php


namespace Aaran\Core\User\Tests\Feature;

use Aaran\Core\User\Models\User;
use Aaran\Core\User\Repositories\UserRepository;
use Aaran\Core\User\Services\UserService;
use Illuminate\Support\Facades\Log;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    protected $userService;
    protected $userRepository;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock UserRepository
        $this->userRepository = Mockery::mock(UserRepository::class);
        $this->userService = new UserService($this->userRepository);
    }

    #[Test]
    public function it_logs_a_warning_when_updating_a_non_existent_user()
    {
        Log::shouldReceive('warning')
            ->once()
            ->with('Update failed: User with ID 999 not found.');

        $this->userRepository->shouldReceive('findById')
            ->with('999')
            ->andReturn(null);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('User not found');

        $this->userService->updateUser('999', ['name' => 'New Name']);
    }

    #[Test]
    public function it_logs_an_error_when_deleting_a_non_existent_user()
    {
        Log::shouldReceive('error')
            ->once()
            ->with('Delete failed: User with ID 999 not found.');

        $this->userRepository->shouldReceive('findById')
            ->with('999')
            ->andReturn(null);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('User not found');

        $this->userService->deleteUser('999');
    }

    #[Test]
    public function it_logs_success_when_a_user_is_deleted()
    {
        $user = User::factory()->make(['id' => 1]);

        Log::shouldReceive('info')
            ->once()
            ->with('User with ID 1 deleted successfully.');

        $this->userRepository->shouldReceive('findById')
            ->with('1')
            ->andReturn($user);

        $this->userRepository->shouldReceive('delete')
            ->with($user)
            ->andReturn(true);

        $this->userService->deleteUser('1');
    }

    #[Test]
    public function it_logs_an_error_when_user_deletion_fails()
    {
        $user = User::factory()->make(['id' => 2]);

        Log::shouldReceive('error')
            ->once()
            ->with('Failed to delete user with ID 2.');

        $this->userRepository->shouldReceive('findById')
            ->with('2')
            ->andReturn($user);

        $this->userRepository->shouldReceive('delete')
            ->with($user)
            ->andReturn(false);

        $this->userService->deleteUser('2');
    }
}
