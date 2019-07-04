<?php

namespace App\InterfaceService;

interface ImageInterface {
    public function createImage($request, $postId);
    public function getImageByPostId($id);
    public function deleteImages($id);
    public function getImageById($id);
    public function updateImagePostID($id, $postId, $position);
    public function listImage($postId);
}
