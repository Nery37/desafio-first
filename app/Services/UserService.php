<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * UserService.
 */
class UserService extends AppService
{
    protected RepositoryInterface $repository;

    /**
     * @param UserRepository $repository
     */
    public function __construct(
        UserRepository $repository,
    ) {
        $this->repository = $repository;
    }

    /**
     * @param array $data
     *
     * @return array
     *
     * @throws \Exception
     */
    public function createUser(array $data): array
    {
        try {
            DB::beginTransaction();
            $user = $this->create($data, true);
            DB::commit();
            return $this->repository->skipPresenter(false)->find($user->id);
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
