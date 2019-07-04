<?php
namespace App\Service;

use App\InterfaceService\ImageInterface;
use App\Media; // model
use Carbon\Carbon;
use Intervention\Image\ImageManagerStatic as Image;

class ImageService implements ImageInterface
{

    public function createImage($request,$post_id=null)
    {
        if($request->hasfile('image')) {
            $listImage = [];
            foreach($request->file('image') as $key => $file)
            {
                $name = Carbon::now()->timestamp.$file->getClientOriginalName();
                $extension = pathinfo( $name, PATHINFO_EXTENSION );
                $name = Carbon::now()->timestamp.'-'.str_random(5).'.'.$extension;
                $file->move(public_path().'/files'.date("/Y/m/d/"), $name);
                $link = public_path().'/files'.date("/Y/m/d/").$name;
                $img = Image::make($link);
                $img->resize(600, 600)->save($link);
                $path = '/files'.date("/Y/m/d/").$name;
                $image = new Media();
                $image->link = $path;
                $image->post_id = $post_id;
                $image->save();
                array_push($listImage, $image);
            }
        }

        return $listImage;
    }

    public function getImageByPostId($id)
    {
        $images = Media::where('post_id', $id)->orderBy('position','asc')->get();

        return $images;
    }

    public function updateImage($id, $request)
    {
        $images = Media::find($id);
        if($request->hasfile('image')) {
            $file = $request->image ;
            $name = Carbon::now()->timestamp.$file->getClientOriginalName();
            $extension = pathinfo( $name, PATHINFO_EXTENSION );
            $name = Carbon::now()->timestamp.'-'.str_random(5).'.'.$extension;
            $file->move(public_path().'/files'.date("/Y/m/d/"), $name);
            $link = public_path().'/files'.date("/Y/m/d/").$name;
            $img = Image::make($link);
            $img->resize(600, 600)->save($link);
            $path = '/files'.date("/Y/m/d/").$name;
            $images->link = $path;
            $images->save();
        }
    }

    public function deleteImages($id)
    {
        $image = Media::find($id);
        $path = public_path().$image->link;
        Media::destroy($id);
        unlink($path);
    }

    public function getImageById($id)
    {
        $image = Media::find($id);

        return $image;
    }



    public function updateImagePostID($id, $postId, $position)
    {
        $image = Media::find($id);
        $image->post_id = $postId;
        $image->position = $position;
        $image->save();
    }

    public function listImage($postId)
    {
        $images = Media::where('post_id', $postId)->orderBy('position','asc')->get();
        $listImage = [];
        foreach ($images as $image) {
            array_push($listImage, $image->id);
        }

        return $listImage;
    }
}


// redis(cache)
// sua lai form upload
//+ upload video + ten images  show address ve khoang cach giua hai diem tren map (api map) //
