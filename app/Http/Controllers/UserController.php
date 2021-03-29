<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Repositories\UserRepository;
use App\Models\User;

class UserController extends BaseController
{
    /** @var  UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }

    /**
     * Display a listing of the User.
     * GET|HEAD /users
     *
     * @param  Request  $request
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $input = $request->except(['skip', 'limit']);
        $users = $this->userRepository->all(
            $input,
            $request->get('skip'),
            $request->get('limit')
        );

        $input['withCount'] = 1;

        return $this->sendResponse(
            $users->toArray(),
            'Users retrieved successfully.',
            ['totalRecords' => $this->userRepository->all($input)]
        );
    }

    /**
     * Store a newly created User in storage.
     * POST /users
     * @param  CreateUserRequest  $request
     *
     * @throws ApiOperationFailedException
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function store(CreateUserRequest $request)
    {
        $input = $request->all();
        $user = $this->userRepository->store($input);

        return $this->sendResponse($user->toArray(), 'User saved successfully.');
    }

    /**
     * Display the specified User.
     * GET|HEAD /users/{id}
     *
     * @param  User  $user
     *
     * @return JsonResponse
     */
    public function show(User $user)
    {
        $user->roles;

        return $this->sendResponse($user->toArray(), 'User retrieved successfully.');
    }

    /**
     * Update the specified User in storage.
     * PUT/PATCH /users/{id}
     * @param  User  $user
     * @param  UpdateUserRequest  $request
     *
     * @throws ApiOperationFailedException
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function update(User $user, UpdateUserRequest $request)
    {
        $input = $request->all();
        $user = $this->userRepository->update($input, $user->id);

        return $this->sendResponse($user->toArray(), 'User updated successfully.');
    }

    /**
     * Remove the specified User from storage.
     * DELETE /users/{id}
     * @param  User  $user
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function destroy(User $user)
    {
        $user->deleteUserImage();
        $user->delete();

        return $this->sendResponse($user, 'User deleted successfully.');
    }
}
