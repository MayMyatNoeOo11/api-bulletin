<?php

namespace App\Dao\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use App\Contracts\Dao\Post\PostDaoInterface;
use Illuminate\Database\QueryException;
class PostDao implements PostDaoInterface
{


    public function getListForAdmin($searchValue)
    {
        $postData=Post::leftjoin('users','users.id','=','posts.created_user_id')
        ->select('posts.*','users.name')

        ->orderBy('posts.created_at','DESC')
        ->get(); 
        //->paginate(10);

        return $postData;
    }
    public function searchForAdmin($searchValue)
    {
        $postData=Post::leftjoin('users','users.id','=','posts.created_user_id')
        ->select('posts.*','users.name');
        
        if(!empty($searchValue))
        {
        $postData=$postData
        ->where('users.name', 'LIKE', "%$searchValue%")
        ->orWhere('posts.title', 'LIKE', "%$searchValue%")
        ->orWhere('posts.description', 'LIKE', "%$searchValue%") ;       
        
        }

        return $postData->orderBy('posts.created_at','DESC')->paginate(10); 
    }

    public function getListForUser($id,$searchValue)
    {
        $postData=Post::leftjoin('users','users.id','=','posts.created_user_id')
        ->select('posts.*','users.name')
        ->where('posts.created_user_id','=',$id);
        if(!empty($searchValue))
        {
        $postData=$postData
        ->where('users.name', 'LIKE', "%$searchValue%")
        ->orWhere('posts.title', 'LIKE', "%$searchValue%")
        ->orWhere('posts.description', 'LIKE', "%$searchValue%") ;       
        
        }

        return $postData->orderBy('posts.created_at','DESC')->paginate(10); 
    }

    public function getListForGuest($searchValue)
    {
        $postData=Post::leftjoin('users','users.id','=','posts.created_user_id')
        ->select('posts.*','users.name')
        ->where('posts.status','1')
        ->whereNull('posts.deleted_at');

        if(!empty($searchValue))
        {
        $postData=$postData
        ->where('users.name', 'LIKE', "%$searchValue%")
        ->orWhere('posts.title', 'LIKE', "%$searchValue%")
        ->orWhere('posts.description', 'LIKE', "%$searchValue%") ;  
        }
       
        return $postData->orderBy('posts.created_at','DESC')->paginate(10); 
    }
    public function getPostbyId($id)
    {
        $postData=Post::find($id);
        return $postData;
    }
    public function getPostInfo($id)
    {
        $postData=Post::leftjoin('users','users.id','=','posts.created_user_id')
        ->select('posts.*','users.name')
        ->where('posts.id',$id)
        ->first();   
                
        return $postData;
    }

    public function updatePost($request,$id)
    {try{
        $old_post_data=Post::find($request->edit_id);
        $old_post_data->title=$request->title;
        $old_post_data->description=$request->description;
        $old_post_data->created_user_id=$request->created_user_id;
        $old_post_data->status=$request->status;
        $old_post_data->updated_at=now();
        $old_post_data->updated_user_id=$request->updated_user_id;
        $result= $old_post_data->save();
    } 
    catch (QueryException $e) {
        var_dump($e->errorInfo);
        $result=false;
    }
      return $result;
    }
    public function savePost($request)
    {try{
        $post=new Post;
        $post->title=$request->title;
        $post->description=$request->description;
        $post->created_user_id=$request->created_user_id;
        $post->updated_user_id=$request->updated_user_id;         
        $post->status='1';          

      $result= $post->Save(); 
    } 
    catch (QueryException $e) {
        var_dump($e->errorInfo);
        $result=false;
    }
      return $result;
      
    }
   
    public function getPostedUsers($id)
    {
        $posted_user=Post::where('created_user_id',$id)->get();
        return $posted_user;
    }
    public function deletePost($request)
    {
                    //delete
                    //$is_deleted=DB::table('posts')->where('id', '=', $id)->delete();
                    Post::find($request->id)->update(['deleted_user_id' =>$request->updated_user_id]);
                    $is_deleted=  Post::find($request->id)->delete();
                    return $is_deleted;
    }

    public function search($searchValue)
    {
      


        return $postData;

    }


}
