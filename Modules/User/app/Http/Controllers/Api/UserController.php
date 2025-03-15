<?php

namespace Modules\User\Http\Controllers\Api;

use App\Exceptions\CustomException;
use App\Http\Controllers\ApiController;
use Modules\User\Http\Requests\CreateUser;
use Modules\User\Http\Requests\UpdateUser;
use Modules\User\Http\Resources\UserResource;
use Modules\User\Models\User;
use Modules\User\Services\UserService;

class UserController extends ApiController
{
    public function __construct(private readonly UserService $userService) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return self::apiBody([
            'users' => UserResource::paginate($this->userService->paginate()),
        ])->apiResponse();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUser $request)
    {
        $user = $this->userService->create($request->validated());

        return self::apiBody([
            'user' => UserResource::make($user),
        ])->apiResponse();
    }

    /**
     * Show the specified resource.
     */
    public function show(User $user)
    {
        return self::apiBody([
            'user' => UserResource::make($user),
        ])->apiResponse();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUser $updateUser, User $user)
    {
        $this->userService->update($user, $updateUser->validated());

        return self::apiBody([
            'user' => UserResource::make($user->refresh()),
        ])->apiResponse();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws \Exception|\Throwable
     */
    public function destroy(User $user)
    {
        if ($user->is(request()->user())) {
            throw new CustomException("can't delete yourself'");
        }

        $this->userService->delete($user);

        return self::apiResponse();
    }
}
