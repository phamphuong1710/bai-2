<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\PostService;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource as PostResource;
use App\Service\ImageService;
use App\Http\Resources\ImageResource as ImageResource;
use App\Service\CategoryService;
use App\Http\Resources\CategoryResource as CategoryResource;
use Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $imageService;
    protected $postService;
    protected $categoryService;

    public function __construct(PostService $postService,
        ImageService $imageService,
        CategoryService $categoryService)
    {
        $this->middleware('auth');
        $this->postService = $postService;
        $this->imageService = $imageService;
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $posts = $this->postService->getAllPost();

        return view('admin.post.list', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories =  $this->categoryService->allCategory();

        return view('admin.post.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $post = $this->postService->createPost($request);
        $listImage = explode(',', $request->list_image);
        foreach ($listImage as $position => $id) {
            $this->imageService->updateImagePostID($id,$post, $position
            );
        }
        $posts = $this->postService->getAllPost();

        return view('admin.post.list', compact('posts'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = $this->postService->getPostById($id);

        return view( 'admin.post.detail', compact('post') );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories =  $this->categoryService->allCategory();
        $post = $this->postService->getPostById($id);
        $images = $this->imageService->getImageByPostId($id);
        $listImage = $this->imageService->listImage($id);
        $listImage = implode(',', $listImage);
        $post->list_image = $listImage;

        return view( 'admin.post.edit',
            [
                'post' => $post,
                'categories' => $categories,
                'images' => $images
            ] );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $id)
    {
        $this->postService->updatePost($id, $request);
        $listImage = explode(',', $request->list_image);
        foreach ($listImage as $position => $image) {
            $this->imageService->updateImagePostID($image,$id, $position
            );
        }
        $posts = $this->postService->getAllPost();

        return redirect()->route('posts.index', compact('posts'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->postService->deletePost($id);
        $posts = $this->postService->getAllPost();

        return view('admin.post.list', compact('posts'));
    }
}
