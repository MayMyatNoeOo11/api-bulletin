<?php

namespace App\Dao\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use App\Contracts\Dao\User\UserDaoInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserDao implements UserDaoInterface
{
    public function getAllUsers($id)
    {
        
        $result=DB::table('users as u1')
        ->join('users as u2','u1.created_user_id','=','u2.id')
        ->select('u1.*','u2.name as created_user_name') 
        ->where('u1.id','<>',$id)
        ->whereNull('u1.deleted_at') 
        ->orderBy('u1.created_at','DESC')
        ->get();
        return $result;
    }
    
    public function getUserList($request)
    {          
        $name=$request->input('name');
        $email=$request->input('email');
        $created_from_date=$request->input('created_from_date');
        $created_to_date=$request->input('created_to_date');

        $result=DB::table('users as u1')
        ->join('users as u2','u1.created_user_id','=','u2.id')
        ->select('u1.*','u2.name as created_user_name') 
        ->where('u1.id','<>',$request->id)
        ->whereNull('u1.deleted_at') ;
               
      
        if(!empty($name))
        {
        $result=$result->where('u1.name','LIKE',"%$name%");
        }

        if(!empty($email))
        {
        $result=$result->where('u1.email','LIKE',"%$email%");
        }
        if((!empty($created_from_date)) && (!empty($created_to_date)))
        {
         //   $result=$result->whereBetween('u1.created_at',[$created_from_date,$created_to_date]);
         $result=$result
         ->whereDate('u1.created_at', '>=', $created_from_date)
         ->whereDate('u1.created_at', '<=', $created_to_date);
        
        }  
        if(!empty($created_from_date) && empty($created_to_date))
        {
        $result=$result->whereDate('u1.created_at','>=',$created_from_date); 
        }
        if(!empty($created_to_date) &&  empty($created_from_date))
        {
            $result=$result->whereDate('u1.created_at','<=',$created_to_date); 
        }
 

        $userData=$result->orderBy('u1.created_at','DESC')->paginate(5);

        return $userData;
    }

    public function getUserbyId($id)
    {
        //$userData=User::Find($id);//password doesnot include
        $userData= DB::table('users')->where('id', '=',$id)->whereNull('deleted_at')->first();
        return $userData;
    }

    public function getUserInfo($id)
    {
        $userData=DB::table('users as u1')
        ->join('users as u2','u1.created_user_id','=','u2.id')
        ->select('u1.*','u2.name as created_user_name') 
        ->where('u1.id','=',$id)
        ->whereNull('u1.deleted_at')
        ->first();
       // $userData=User::Find($id);   
        

        return $userData;
    }

    public function saveUser($request)
    {
        //User::create($request->all());
        try{
        $user=new User;
        $user->name=$request->name;
        $user->email=$request->email;
        $user->phone=$request->phone;
        $user->address=$request->address;  
        $user->password=Hash::make($request->password) ;     
        $user->type=$request->type;//'1';  
        $user->date_of_birth=$request->date_of_birth;
        $user->created_user_id=$request->created_user_id;  
        $user->updated_user_id=$request->updated_user_id;  
        $user->created_at=now();   
        $user->updated_at=now();
        $user->remember_token=str::random(10); 
        $user->profile_photo=$request->profile_photo;        

        $result= $user->Save();
    } 
    catch (QueryException $e)
     {
        var_dump($e->errorInfo);
        $result=false;
    }
      return $result;
       
    }

    public function updateUser($request,$id)
    {try{
      $result=  DB::table('users')
            ->where('id', $request->edit_id)
            ->update([
                'name' => $request->name,
                'email'=>$request->email,
                'phone'=>$request->phone,
                'address'=>$request->address,
                'profile_photo'=>$request->profile_image,
                'date_of_birth'=>$request->date_of_birth,
                'type'=>$request->type,
                'updated_user_id'=>$request->updated_user_id,
                'updated_at'=>now()

            ]);
          
        } 
        catch (QueryException $e)
         {
            var_dump($e->errorInfo);
            $result=false;
        }
          return $result;


        //$old_user_data=User::find($id);
        // $old_user_data->name=$request->name;
        // $old_user_data->email=$request->email;
        // $old_user_data->phone=$request->phone;
        // $old_user_data->address=$request->address;  
        // $old_user_data->password=Hash::make($request->password) ;     
        // $old_user_data->type=$request->type;  
        // $old_user_data->date_of_birth=$request->date_of_birth;
        // //$old_user_data->created_user_id=Auth::user()->id;  
        // $old_user_data->updated_user_id=Auth::user()->id;  
        // //$old_user_data->created_at=now();   
        // $old_user_data->updated_at=now();
        //$old_user_data->Save();  
    }

    /**
     * Check whether user has created post or not
     */

    public function checkUserPosted($id)
    {
        $result= DB::table('posts')->where('created_user_id', '=',$id)->whereNull('deleted_at')->get();
       
        if ($result->isEmpty()) 
        { 
            return 0; //if there is no post
        }
        return 1;
    }

    public function deleteUser($request)
    {   

            //delete
            User::find($request->id)->update(['deleted_user_id' => $request->deleted_user_id]);
            $is_deleted=  User::where('id',$request->id)->delete();//DB::table('users')->where('id', '=', $id)->delete();
            return $is_deleted;


    } 
    
    public function changePassword($request)
    {
        $is_change=User::find($request->id)->update(['password'=> Hash::make($request->new_password),
                                            'updated_at'=>now(),
                                            'update_user_id'=>$request->updated_user_id]);
    return $is_change;
    }
    
}