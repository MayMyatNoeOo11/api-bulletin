<?php

namespace App\Contracts\Services\Post;


interface PostServiceInterface
{
   
    public function getListForAdmin($searchValue);
    public function searchForAdmin($searchValue);
    public function getListForUser($id,$searchValue);
    public function getListForGuest($searchValue);
    public function getPostbyId($id);
    public function getPostInfo($id);
    public function updatePost($request,$id);
    public function savePost($request);
    public function getPostedUsers($id);
    public function deletePost($request);
    public function search($searchValue);

}
