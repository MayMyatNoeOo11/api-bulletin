<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Contracts\Services\Post\PostServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Exports\PostsExport;
use App\Imports\PostsImport;
use Maatwebsite\Excel\Facades\Excel;
class PostApiController extends Controller
{
    public $postService;
    public function __construct(PostServiceInterface $post_service_interface)
    {
       
        $this->postService = $post_service_interface;
    }
    public function search(Request $request)
    {
        $postData=$this->postService->searchForAdmin($request->searchValue);
        return response()->json($postData);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }    


    public function createConfirm(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'title'=>'required|max:255|unique:posts,title,NULL,id,deleted_at,NULL',
            'description'=>'required'
            ],
            [
            'title.required'=>'Title is required.',
            'title.max'=>'The title cannot be longer than 255 words.',
            'title.unique'=>'Post already exist',
            'description.required'=>'Description is required.'
            ]);
            if($validator->fails())
            {
                $postData=["post"=>$request->all(),
                        "isValidate"=>false,
                        "errors"=>$validator->errors()
                    ];
                
            }
            else
            {
                $postData=["post"=>$request->all(),
                "isValidate"=>true,              
                    ];

            }
            return response()->json($postData);          
            
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'title'=>'required|max:255|unique:posts,title,NULL,id,deleted_at,NULL',
            'description'=>'required'
            ],
            [
            'title.required'=>'Title is required.',
            'title.max'=>'The title cannot be longer than 255 words.',
            'title.unique'=>'Post already exist',
            'description.required'=>'Description is required.'
            ]);    

            if($validator->fails())
            {
                $responseData=[
                "post"=>$request->all(),
                "success"=>false,
                "message"=>"Fail.Validation errors occur.",
                "errors"=>$validator->errors()];
               
            }
            else
            {
            $postData=$this->postService->savePost($request);
                if($postData==true)
                {
                $responseData=[
                    "post"=>$request->all(),
                    "success"=>true,
                    "message"=>"Post created successfully."];
                    
                }
                else
                {
                    $responseData=[
                        "post"=>$request->all(),
                        "success"=>false,
                        "message"=>"Post created fail."];
                        

                }
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
        $post=$this->postService->getPostInfo($id);
        return response()->json(["post"=>$post]);
    }

        /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $postData=$this->postService->getPostbyId($id);

     return response()->json(["post"=>$postData]);    
    }

    public function showAllPosts()
    {
        $postData=$this->postService->getListForAdmin('');
        //return $postData;
        return response()->json($postData);
    }
  /**
     * Validate and confirm user input.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function updateConfirm(Request $request)
    {
        $validator=Validator::make($request->all(),[
        'title'=>['required', Rule::unique('posts')->ignore($request->edit_id)],
        'description'=>'required'],        
    
        ['title.required'=>'Title is required.',
        'title.max'=>'The title cannot be longer than 255 words.',
        'title.unique'=>'Post already exist',
        'description.required'=>'Description is required.'
        ]);
        if($validator->fails())
        {
            $postData=["post"=>$request->all(),
                    "isValidate"=>false,
                    "errors"=>$validator->errors()
                ];
            
        }
        else
        {
            $postData=["post"=>$request->all(),
            "isValidate"=>true,              
                ];

        }
        return response()->json($postData);  

    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      
        $validator=Validator::make($request->all(),[
            'title'=>['required', Rule::unique('posts')->ignore($request->edit_id)],
            'description'=>'required'],        
        
            ['title.required'=>'Title is required.',
            'title.max'=>'The title cannot be longer than 255 words.',
            'title.unique'=>'Post already exist',
            'description.required'=>'Description is required.'
            ]);
      if($validator->fails())
            {
                $responseData=[
                "post"=>$request->all(),
                "success"=>false,
                "message"=>"Fail.Validation errors occur.",
                "errors"=>$validator->errors()];
               
            }
            else
            {
            $postData=$this->postService->updatePost($request,'1');
                if($postData==true)
                {
                $responseData=[
                    "post"=>$request->all(),
                    "success"=>true,
                    "message"=>"Post created successfully."];
                    
                }
                else
                {
                    $responseData=[
                        "post"=>$request->all(),
                        "success"=>false,
                        "message"=>"Post created fail."];
                        

                }
             }
             return response()->json($responseData);

    }
    public function destroy(Request $request) //delete post confirm
    {
      //  $is_deleted=true;
      $is_deleted=$this->postService->deletePost($request);
      if($is_deleted==1)
      { 
          $message="Post deleted successfully.";
          $responseData=["success"=>true,"post"=>$request->all(),"message"=>$message];       
      
      }
      else
      {
        $message="Post delete fail !";
        $responseData=["success"=>false,"post"=>$request->all(),"message"=>$message];        
      }
      return response()->json($responseData);
    }
    public function export() 
    {
        return Excel::download(new PostsExport, 'posts.xlsx');
    }
    public function import(Request $request)
    {
      Excel::import(new PostsImport,request()->file('fileUpload'));
    return response()->json(["message"=>"import successfully"]);
    }
}
