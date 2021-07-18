<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Contracts\Services\User\UserServiceInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Auth;
use Session;
use File;
use Illuminate\Validation\Rule;
class UserApiController extends Controller
{
    public $userService;
    public function __construct(UserServiceInterface $user_service_interface)
    {
      $this->userService = $user_service_interface;
    } 
    public function photo_store(Request $request)
    {
        
        if($request->hasFile('profile_photo'))
        {               // Get image file
            $image = $request->file('profile_photo'); 
            $destinationPath = 'storage/images/'; // upload path
            $profileImage = date('YmdHis') . "_Profile." . $image->getClientOriginalExtension();
            $file_full_path=$destinationPath.'/'.$profileImage;
            $image->move($destinationPath, $profileImage); 

        return $profileImage;
        // $image->move(public_path('images'), $imageName);//store in public
        }
        else
        {
            $profileImage="";

        }
        return $profileImage;
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
      //  $profileImage=$this->photo_store($request);

      if($validator->fails())
      {
          $userData=["user"=>$request->all(),
                  "isValidate"=>false,
                  "errors"=>$validator->errors(),
                  "profileImage"=>'',
                  "message"=>"validation fail",
                  "hasFile"=>false

              ];
          
      }
      else
      {
        if($request->hasFile('profile_photo'))
        {
            $hasfile=true;
          
            $profileImage=$this->photo_store($request);
  
        }
        else{
          $hasfile=false;
          $profileImage="";
        }

          $userData=["user"=>$request->all(),
                    "isValidate"=>true,
                    "profileImage"=>$profileImage              
              ];

      }
      return response()->json($userData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
          $validator = Validator::make($request->all(), [
            'name'=>'required|unique:users',
            'email' => 'required|email|unique:users,email,regex:/^(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/',        
            'profile_photo' => 'required',//|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
          
         
            if($validator->fails())
            {
                $responseData=[
                "user"=>$request->all(),
                "success"=>false,
                "message"=>"Fail.Validation errors occur.",
                "errors"=>$validator->errors()];
               
            }
            else
            {
          
            $userData=$this->userService->saveUser($request);
                if($userData==true)
                {
                $responseData=[
                    "user"=>$request->all(),
                    "success"=>true,
                    "message"=>"User created successfully."];
                    
                }
                else
                {
                    $responseData=[
                        "user"=>$request->all(),
                        "success"=>false,
                        "message"=>"User created fail."];
                        

                }
             }
             return response()->json($responseData);

        
    }
    public function updateConfirm(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'name'=>['required',Rule::unique('users')->ignore($request->id)],
                'email' => ['required','email', Rule::unique('users')->ignore($request->id)],
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
            
      if($validator->fails())
      {
          $userData=["user"=>$request->all(),
                  "isValidate"=>false,
                  "errors"=>$validator->errors(),
                  "profileImage"=>'',
                  "message"=>"validation fail",
                  "hasFile"=>false

              ];
            }
        else
        {
            if($request->hasFile('profile_photo'))//new profile
            { 
                $old_photo=$request->old_photo;
                File::delete('storage/images/'.$old_photo);
                $profileImage=$this->photo_store($request);
                    
            }
            else //old profile
            {
                $profileImage=$request->old_photo;       
            }
          
            $userData=[
                "user"=>$request->all(),
                "isValidate"=>true,           
                "profileImage"=> $profileImage,
                "message"=>"validation success",
                "hasFile"=>true ];

                    
        }
        
        return response()->json($userData);
     
    }
    public function update(Request $request)
    {        
        $userData= $this->userService->updateUser($request,'1'); 
        
        if($userData==true)
        {
        $responseData=[
            "user"=>$request->all(),
            "success"=>true,
            "message"=>"User updated successfully."];
            
        }
        else
        {
            $responseData=[
                "user"=>$request->all(),
                "success"=>false,
                "message"=>"User update fail."];
                

        }
     
     return response()->json($responseData);
            
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

        return response()->json(["user"=>$user]);
   
  
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $userData=$this->userService->getUserbyId($id);

     return response()->json(["user"=>$userData]);    
    }

    public function checkDelete($id)
    {
       // $data=$this->userService->getUserbyId($id);    
        $checkUserPosted=$this->userService->checkUserPosted($id);
        if($checkUserPosted)
        {
            $responseData=["canDelete"=>false,"id"=>$id];

        }
        else
        {
            $responseData=["canDelete"=>true,"id"=>$id];
        }      
        return response()->json($responseData);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $is_deleted=$this->userService->deleteUser($request);
        if($is_deleted==1)
        {
            $message="User deleted successfully.";
            $responseData=["success"=>true,"user"=>$request->all(),"message"=>$message];
            
        }
        else
        {
            $message="User delete fail !";
            $responseData=["success"=>false,"user"=>$request->all(),"message"=>$message];
          
        }
        return response()->json($responseData);
    }
    // public function search(Request $request)
    // {
    //     $searchResult=$this->userService->getUserList($request);
    //     return $searchResult;
    // }
       /**
     * Change Password 
     * @param  \Illuminate\Http\Request  $request
     */
    public function changePassword(Request $request)
    {       


        $validator = Validator::make($request->all(), [
        'old_password' =>['required',new MatchOldPassword($request->password)],
        'new_password' => ['required','min:8','different:old_password','regex:/^(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/'],
        'new_confirm_password' => ['required','min:8','same:new_password']
         ],
         [
         'old_password.required'=>'Old Password is required.',
         'new_password.required'=>'New Password is required.',
         'new_confirm_password.required'=>'Confirm password is required.',
         'new_password.different'=>'New password must be different from old password.',
         'new_confirm_password.same'=>'New password and new confirm password must be the same' ,
         'new_password.regex'=>'Must contain at least 1 Uppercase letter and 1 numeric.'      

         ]);    
        
      
 
        if($validator->fails())
        {
            $userData=[
                    "user"=>$request->all(),
                    "isValidate"=>false,
                    "errors"=>$validator->errors()
                ];
            
        }
        else
        {  $is_change_password=$this->userService->changePassword($request);
            $userData=[
            "user"=>$request->all(),
            "isValidate"=>true,              
                ];

        }
        return response()->json($userData);  

    }
}
