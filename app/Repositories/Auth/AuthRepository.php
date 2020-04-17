<?php


namespace App\Repositories\Auth;


use App\PasswordReset;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use phpseclib\Crypt\Hash;

class AuthRepository
{

    public function createUser($input){
      return   $user = User::create($input);
    }

    public function findUserByEmail($email){
        return User::where('email', $email)->first();
    }

    public function updateOrCreateResetPassword($email,$token){
        return PasswordReset::updateOrCreate(
            ['email' => $email], ['email' => $email, 'token' => $token]
        );
    }

    public function findPeopleToken($token) {
        return PasswordReset::where('token', $token)->first();
    }

    public function resetPassword($token,$email){
        return PasswordReset::where([ ['token', $token], ['email', $email] ])->first();
    }

    public function getUserByEmail($email){
        return User::where('email', $email)->first();
    }

    public function saveUser($user){
         $user->save();
    }

    public function deletePasswordReset($deletePasswordReset){
        $deletePasswordReset->delete();
    }

    public function allUsers(){
        return User::all();
    }

    public function findUsrById($id){
        return User::where('id',$id)->first();
    }


}
