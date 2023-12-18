<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Services\AppService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class UsersController.
 */
class UsersController extends Controller
{
    protected AppService $service;

    /**
     * @param UserService $service
     */
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function createUser(CreateUserRequest $request): JsonResponse
    {
        try {
            return $this->successCreatedResponse($this->service->createUser($request->all()));
        } catch (\Exception $exception) {
            return $this->undefinedErrorResponse($exception->getMessage(), $exception->getCode());
        }
    }
}
