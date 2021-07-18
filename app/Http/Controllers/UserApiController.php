<?php

namespace App\Http\Controllers;
use App\Contracts\Services\User\UserServiceInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Auth;
use Session;
class UserApiController extends Controller
{
    public $userService;
    public function __construct(UserServiceInterface $user_service_interface)
    {
      $this->userService = $user_service_interface;
    } 
        /**
     * Login
     */
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $success = true;
            $message = 'User login successfully';
           // $token = auth()->user()->createToken('remember_token')->accessToken;
            $user=Auth::user();
        } else {
            $success = false;
            $message = 'Unauthorised';
            $user=$credentials;
          //  $token=null;
        }

        // response
        $response = [
            'success' => $success,
            'message' => $message,
            'user' => $user,
           // 'token'=>$token
        ];
        return response()->json($response);
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        try {
            Session::flush();
            $success = true;
            $message = 'Successfully logged out';
        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }

        // response
        $response = [
            'success' => $success,
            'message' => $message,
        ];
        return response()->json($response);
         //$accessToken = auth()->user()->token();
        // $token= $request->user()->tokens->find($accessToken);
        // $token->revoke();
        //  $response = [
        //      'success' => $success,
        //      'message' => $message,
        //  ];

    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $userData=$this->userService->getAllUsers($id);

        return $userData;
    }

    public function createConfirm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required|unique:users',
            'email' => 'required|email|unique:users,email,regex:/^(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/',        
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',//|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'date_of_birth'=>'required|date',
            'password' => 'required|min:8|confirmed|regex:/^(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/',
            'password_confirmation' => 'required| min:8|regex:/^(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/'
            ],
            [
            'name.required'=>'Name is required.',
            'email.required'=>'Email is required',
            'profile_photo.required'=>'Profile photo is required.',
            'password.required'=>'Password is required.',
            'password_confirmation.required'=>'Confirm Password is required.',
            'date_of_birth.required'=>'Date of birth is required.',
            'name.unique'=>'The user name is already exist.',
            'email.email'=>'Email must be a valid email address.',
            'email.unique'=>'The user with this email already exist',
            'password.confirmed'=>'Password and confirm password must be the same.',
            'password.min'=>'Password must be more than 8 characters long.',   
            'password_confirmation.min'=>'Confirm password must be more than 8 characters long.'

        ]);
        if ($validator->fails())
        { 
            $respnse=["user"=>$request,"success"=>false,"message"=>"Validations errors.","errors"=>$validator->errors()];

            return response()->json($response, 422);
        }
        else
        {
            $respnse=["user"=>$request,"success"=>true,"message"=>"Validations passed."];
            return response()->json($respnse, 201);

        }   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|unique:users',
            'email' => 'required|email|unique:users,email,regex:/^(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/',        
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,jfif,gif,svg|max:2048',//|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'date_of_birth'=>'required|date',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required| min:8'
            ],
            [
            'name.required'=>'Name is required.',
            'email.required'=>'Email is required',
            'profile_photo.required'=>'Profile photo is required.',
            'password.required'=>'Password is required.',
            'password_confirmation.required'=>'Confirm Password is required.',
            'date_of_birth.required'=>'Date of birth is required.',
            'name.unique'=>'The user name is already exist.',
            'email.email'=>'Email must be a valid email address.',
            'email.unique'=>'The user with this email already exist',
            'password.confirmed'=>'Password and confirm password must be the same.',
            'password.min'=>'Password must be more than 8 characters long.',   
            'password_confirmation.min'=>'Confirm password must be more than 8 characters long.'
            ]);
            $userData=$this->userService->saveUser($request);
            return response()->json($userData, 201);

        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      
        $user=$this->userService->getUserInfo($id);

        return response()->json($user);
   
  
    }

        /**
     * Show the form for user profile
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profile($id)
    {
        $userData=$this->userService->getUserbyId($id);
        
        return $userData;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>['required',Rule::unique('users')->ignore($id)],
            'email' => ['required','email', Rule::unique('users')->ignore($id)],
            'date_of_birth'=>'required|date'
        ],
        [
            'name.required'=>'Name is required.',
            'email.required'=>'Email is required',
            'date_of_birth.required'=>'Date of birth is required.',
            'name.unique'=>'The user name is already exist.',
            'email.email'=>'Email must be a valid email address.',
            'email.unique'=>'The user with this email already exist'
        ]);

        $userData=$this->userService->updateUser($request,$id); 
        return response()->json($userData, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $is_deleted=$this->userService->deleteUser($request->id);
        if($is_deleted==1)
        {
            $message="User has been deleted successfully.";
            
        }
        else
        {
          $message="User delete fail !";
          
        }
    }
}
