<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * AuthController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('signOut');
        $this->middleware('ajax')->only('signIn');
    }

    /**
     * Display sign in form.
     *
     * @return View
     */
    public function showSignInForm(): View
    {
        return view('auth/sign-in');
    }

    /**
     * Process authentication attempt.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function signIn(Request $request): JsonResponse
    {
        $credentials = $request->only(['username', 'password']);

        $validator = Validator::make($credentials, [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'response' => trans('messages.auth.sign-in-invalid'),
                'errors' => $validator->errors(),
            ]);
        }

        if (Auth::attempt($credentials, $request->filled('remember_me'))) {
            Auth::user()->update([
                'logged_at' => Carbon::now()
            ]);

            return response()->json([
                'code' => JsonResponse::HTTP_OK,
                'response' => trans('messages.auth.sign-in-successful'),
                'redirect' => route('showDashboard'),
            ]);
        }

        return response()->json([
            'code' => JsonResponse::HTTP_UNAUTHORIZED,
            'response' => trans('messages.auth.sign-in-failed'),
        ]);
    }

    /**
     * Sign the user out.
     *
     * @return RedirectResponse
     */
    public function signOut(): RedirectResponse
    {
        Auth::logout();

        return redirect(route('showSignInForm'));
    }
}
