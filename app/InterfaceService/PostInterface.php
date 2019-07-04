<?php

namespace App\InterfaceService;

interface PostInterface {
    public function createPost($request);
    public function getPostById($id);
    public function getAllPost();
    public function deletePost($id);
}
