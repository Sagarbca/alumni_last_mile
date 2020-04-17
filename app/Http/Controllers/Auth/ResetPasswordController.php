<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetFormPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Repositories\Auth\AuthRepository;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Carbon\Carbon;
use App\Notifications\PasswordResetRequest;
use App\Notifications\PasswordResetSuccess;
use Illuminate\Support\Str;


class ResetPasswordController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AuthRepository $authRepository)
    {
        //$this->middleware('guest');
        $this->authRepository = $authRepository;
    }

    public function create(ResetPasswordRequest $request){
        $user = $this->authRepository->findUserByEmail($request->email);
        if (!$user)
            return response()->json(['message' => "We can't find a user with that e-mail address."], 404);

        $passwordReset = $this->authRepository->updateOrCreateResetPassword($user->email,Str::random(60));
        if ($user && $passwordReset)
            $user->notify(new PasswordResetRequest($passwordReset->token));
        return response()->json(['message' => 'We have e-mailed your password reset link!']);
    }


    public function find($token){
        $passwordReset = $this->authRepository->findPeopleToken($token);
        if (!$passwordReset)
            return response()->json(['message' => 'This password reset token is invalid.'], 404);
        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();
            return response()->json(['message' => 'This password reset token is invalid.'], 404);
        }
        return response()->json($passwordReset);
    }


    public function reset(ResetFormPasswordRequest $request){

        $passwordReset = $this->authRepository->resetPassword($request->token,$request->email);
        $user = $this->authRepository->getUserByEmail($request->email);
        if (!$user)
            return response()->json(['message' => "We can't find a user with that e-mail address."], 404);
        $user->password = bcrypt($request->password);
        $this->authRepository->saveUser($user);
        $this->authRepository->deletePasswordReset($passwordReset);
        $user->notify(new PasswordResetSuccess($passwordReset));
        return response()->json($user);
    }
}
