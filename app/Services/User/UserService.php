<?php

namespace App\Services\User;

use App\Contracts\Dao\User\UserDaoInterface;
use App\Contracts\Services\User\UserServiceInterface;
class UserService implements UserServiceInterface
{
    public $userDao;
    public function __construct(UserDaoInterface $user_dao_interface)
    {
        $this->userDao = $user_dao_interface;
    }
    public function getAllUsers($id)
    {
        return $this->userDao->getAllUsers($id);
    }

    public function getUserList($request)
    {
        return $this->userDao->getUserList($request);
    }
    public function getUserbyId($id)
    {
        return $this->userDao->getUserbyId($id);
    }
    public function getUserInfo($id)
    {
        $user= $this->userDao->getUserInfo($id);
         // $userInfo=new Object;
        // $userInfo->name=$user->name;
        // $userInfo->email=$user->email;
        // $userInfo->created_at=$user->created_at;
        // $userInfo->updated_at=$user->updated_at;
        // $userInfo->created_user_name=$user->created_user_name;
        // $userInfo->phone=$user->phone;
        // $userInfo->address=$user->address;
        // $userInfo->date_of_birth=$user->date_of_birth;
        // $userInfo->type=$user->type;
        // $userInfo->profile_photo=public_path('images/profiles/').$user->profile_photo;
        return $user;
    }
    public function saveUser($request)
    {
        return $this->userDao->saveUser($request);
    }
    public function updateUser($request,$id)
    {
        return $this->userDao->updateUser($request,$id);
    }
    public function checkUserPosted($id)
    {
        return $this->userDao->checkUserPosted($id); 
    }
    public function deleteUser($request)
    {
        return $this->userDao->deleteUser($request);
    }
    public function changePassword($request)
    {
        return $this->userDao->changePassword($request);
    }

}