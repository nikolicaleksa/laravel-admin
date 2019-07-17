<?php

namespace App\Http\Controllers;

use Exception;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class UserController extends Controller
{
    private const USERS_PER_PAGE = 15;


    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('ajax')->only(['deleteUser', 'addUser', 'updateUser']);
    }

    /**
     * Display list of users.
     *
     * @return View
     */
    public function showUsersList(): View
    {
        $users = User::select(['id', 'first_name', 'last_name', 'username', 'created_at', 'logged_at'])
            ->oldest()
            ->paginate(self::USERS_PER_PAGE);

        return view('users/users', [
            'users' => $users
        ]);
    }

    /**
     * Display add user form.
     *
     * @return View
     */
    public function showAddUserForm(): View
    {
        return view('users/add-user');
    }

    /**
     * Display edit user form.
     *
     * @param User $user
     *
     * @return View
     */
    public function showEditUserForm(User $user): View
    {
        return view('users/edit-user', [
            'user' => $user
        ]);
    }

    /**
     * Delete user from the system.
     *
     * @param User $user
     *
     * @return JsonResponse
     */
    public function deleteUser(User $user): JsonResponse
    {
        try {
            $user->delete();
        } catch (Exception $ex) {
            return response()->json([
                'code' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'response' => trans('messages.failure.unknown-error')
            ]);
        }

        return response()->json([
            'code' => JsonResponse::HTTP_OK,
            'response' => trans('messages.users.user-deleted')
        ]);
    }

    /**
     * Add new user to the system.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function addUser(Request $request): JsonResponse
    {
        $userData = $request->only(['first_name', 'last_name', 'username', 'password']);

        $validator = Validator::make($userData, [
            'first_name' => 'required|string|max:64',
            'last_name' => 'required|string|max:64',
            'username' => 'required|string|max:64',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'response' => trans('messages.invalid.form'),
                'messages' => $validator->errors(),
            ]);
        }

        try {
            $userData['password'] = bcrypt($userData['password']);

            User::create($userData);
        } catch (QueryException $ex) {
            return response()->json([
                'code' => JsonResponse::HTTP_BAD_REQUEST,
                'response' => trans('messages.users.username-taken'),
            ]);
        }

        return response()->json([
            'code' => JsonResponse::HTTP_OK,
            'response' => trans('messages.users.user-added'),
            'redirect' => route('showUsersList')
        ]);
    }

    /**
     * Update existing user information.
     *
     * @param User $user
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function updateUser(User $user, Request $request): JsonResponse
    {
        $userData = $request->only(['first_name', 'last_name', 'username', 'password']);

        $validator = Validator::make($userData, [
            'first_name' => 'required|string|max:64',
            'last_name' => 'required|string|max:64',
            'username' => 'required|string|max:64',
            'password' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'response' => trans('messages.invalid.form'),
                'messages' => $validator->errors(),
            ]);
        }

        if (!empty($userData['password'])) {
            $userData['password'] = bcrypt($userData['password']);
        } else {
            unset($userData['password']);
        }

        try {
            $user->update($userData);
        } catch (QueryException $ex) {
            return response()->json([
                'code' => JsonResponse::HTTP_BAD_REQUEST,
                'response' => trans('messages.users.username-taken'),
            ]);
        }

        return response()->json([
            'code' => JsonResponse::HTTP_OK,
            'response' => trans('messages.users.user-saved'),
            'redirect' => route('showUsersList')
        ]);
    }
}
