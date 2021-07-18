<?php

namespace App\Http\Controllers;
use App\Contracts\Services\Post\PostServiceInterface;
use Illuminate\Http\Request;


class PostApiController extends Controller
{
    public $postService;
    public function __construct(PostServiceInterface $post_service_interface)
    {
       
        $this->postService = $post_service_interface;
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required|max:255|unique:posts,title,NULL,id,deleted_at,NULL',
            'description'=>'required'
            ],
            [
            'title.required'=>'Title is required.',
            'title.max'=>'The title cannot be longer than 255 words.',
            'title.unique'=>'Post already exist',
            'description.required'=>'Description is required.'
            ]);    

            $postData=$this->postService->savePost($request);
            return response()->json($postData, 201);
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
        return $post; 
    }
    public function showAllPosts()
    {
        $postData=$this->postService->getListForAdmin('');
        //return $postData;
        return response()->json($postData);
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
            'title'=>['required', Rule::unique('posts')->ignore($id)],
            'description'=>'required'],        
        
            ['title.required'=>'Title is required.',
            'title.max'=>'The title cannot be longer than 255 words.',
            'title.unique'=>'Post already exist',
            'description.required'=>'Description is required.'
            ]);

            $postData=$this->postService->updatePost($request,$id);
            return response()->json($postData, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
