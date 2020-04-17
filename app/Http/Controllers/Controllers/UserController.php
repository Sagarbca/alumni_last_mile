<?php
namespace App\Http\Controllers;
use App\Helpers\Helper;
use App\Http\Requests\RegisterFormRequest;
use App\Notifications\PasswordResetRequest;
use App\Notifications\RegisterMailSuccess;
use App\Repositories\Auth\AuthRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public $successStatus = 200;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function login(){
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')]) || Auth::attempt(['mobile_number' => request('mobileNumber'), 'password' => request('password')]) || Auth::attempt(['username' => request('username'), 'password' => request('password')])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')-> accessToken;
            $success['id'] = $user->id;
            $success['userName'] = $user->first_name;
            return response()->json(['success' => $success], $this-> successStatus);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }
    public function register(RegisterFormRequest $request)
    {
        $input = $request->all();
        $snaked_request = Helper::changeRequestSnakeCase($input);
        $snaked_request['password'] = bcrypt($snaked_request['password']);
        $user = $this->authRepository->createUser($snaked_request);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->first_name;
        $user->notify(new RegisterMailSuccess($user->first_name));
        return response()->json(['success'=>$success], $this-> successStatus);
    }


    public function details()
    {
        $user = $this->authRepository->allUsers();
        return response()->json(['success' => $user], $this-> successStatus);
    }


    public function userDetailById(Request $request){
        $id = $request->id;
        return $userDetail = $this->authRepository->findUsrById($id);
    }
}
