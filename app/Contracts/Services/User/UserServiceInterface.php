<?php

namespace App\Contracts\Services\User;


interface UserServiceInterface
{
    public function getAllUsers($id);
    public function getUserList($request);
    public function getUserbyId($id);
    public function getUserInfo($id);
    public function saveUser($request);
    public function updateUser($request,$id);
    public function checkUserPosted($id);
    public function deleteUser($request);
    public function changePassword($request);

}
