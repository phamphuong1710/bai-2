<?php
namespace App\Service;

use App\InterfaceService\CategoryInterface;
use App\Category; // model

class CategoryService implements CategoryInterface
{

    public function createCategory($request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->slug = str_slug( $request->name, '-' );

        $category->save();
    }

    public function getCategoryById($id)
    {
        $category = Category::find($id);

        return $category;
    }

    public function updateCategory($id, $request)
    {
        $category = Category::find($id);
        $category->name = $request->name;
        $category->slug = str_slug( $request->name, '-' );

        $category->save();
    }

    public function deleteCategory($id)
    {
        Category::destroy($id);
    }

    public function allCategory()
    {
        $categories = Category::all();

        return $categories;
    }
}

