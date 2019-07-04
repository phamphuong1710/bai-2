<?php
namespace App\Service;

use App\InterfaceService\PostInterface;
use App\Post; // model
use Carbon\Carbon;

class PostService implements PostInterface
{

    public function createPost($request)
    {
        $current_date_time = Carbon::now()->timestamp;
        $post = new Post();
        $post->title = $request->title;
        $post->slug = str_slug( $request->title ).$current_date_time;
        $post->category_id = $request->category_id;
        $post->user_id = $request->user_id;
        $post->content = $request->content;
        $post->save();

        return $post->id;
    }

    public function getPostById($id)
    {
        $posts = Post::find($id);

        return $posts;
    }

    public function updatePost($id, $request)
    {
        $post = Post::find($id);
        $current_date_time = Carbon::now()->timestamp;
        $post->title = $request->title;
        $post->slug = str_slug( $request->title ).$current_date_time;
        $post->category_id = $request->category_id;
        $post->user_id = $request->user_id;
        $post->content = $request->content;
        $post->save();
    }

    public function deletePost($id)
    {
        Post::destroy($id);
    }

    public function getAllPost()
    {
        $posts = Post::paginate(10);

        return $posts;
    }
}

