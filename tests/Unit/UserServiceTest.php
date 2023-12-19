<?php

namespace Tests\Unit;

use App\Entities\User;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Database\Factories\UserFactory;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    protected $mockUserRepository;
    protected $userService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockUserRepository = $this->createMock(UserRepository::class);
        $this->userService = new UserService($this->mockUserRepository);
    }

    public function test_create_user_successfully()
    {
        DB::beginTransaction();

        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
        ];

        $this->mockUserRepository->expects($this->exactly(2))
            ->method('skipPresenter')
            ->willReturnSelf();

        $this->mockUserRepository->expects($this->once())
            ->method('create')
            ->willReturn(UserFactory::new()->make($userData));

        $this->mockUserRepository->expects($this->once())
            ->method('find')
            ->willReturn([
                'data' => $userData
            ]);

        $result = $this->userService->createUser($userData);
        $this->assertEquals(['data' => $userData], $result);

        DB::rollBack();
    }
}
