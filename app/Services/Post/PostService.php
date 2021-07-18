<?php

namespace App\Services\Post;

use App\Contracts\Dao\Post\PostDaoInterface;
use App\Contracts\Services\Post\PostServiceInterface;
class PostService implements PostServiceInterface
{
    public $postDao;
    public function __construct(PostDaoInterface $post_dao_interface){
        $this->postDao = $post_dao_interface;
    }


    public function getListForAdmin($searchValue)
    {
        return $this->postDao->getListForAdmin($searchValue);
    }
    public function searchForAdmin($searchValue)
    {
        return $this->postDao->searchForAdmin($searchValue);
    }
    public function getListForUser($id,$searchValue)
    {
        return $this->postDao->getListForUser($id,$searchValue);
    }
    public function getListForGuest($searchValue)
    {
        return $this->postDao->getListForGuest($searchValue);
    }
    public function getPostbyId($id)
    {
        return $this->postDao->getPostbyId($id);
    }
    public function getPostInfo($id)
    {
        return $this->postDao->getPostInfo($id);
    }
    public function updatePost($request,$id)
    {
        return $this->postDao->updatePost($request,$id);
    }
    public function savePost($request)
    {
        return $this->postDao->savePost($request);
    }
    public function getPostedUsers($id)
    {
        return $this->postDao->getPostedUsers($id);
    }
    public function deletePost($request)
    {
        return $this->postDao->deletePost($request);
    }
    public function search($searchValue)
    {
        return $this->postDao->search($searchValue); 
    }
    

}
