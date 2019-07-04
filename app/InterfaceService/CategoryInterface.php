<?php

namespace App\InterfaceService;

interface CategoryInterface {
    public function createCategory($request);
    public function getCategoryById($id);
    public function updateCategory($id, $request);
    public function deleteCategory($id);
}
