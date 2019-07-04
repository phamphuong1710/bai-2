<?php
namespace App\Service;

use App\InterfaceService\VideoInterface;
use App\Image;
use App\Video; // model
use Carbon\Carbon;

class VideoService implements VideoInterface
{

    public function createVideo($request)
    {
        $image = new Image();
        $video =new Video();
        $video->link = $request->link;
        $video->save();
        $videoId = $video->id;
        $image->video_id = $videoId;
        $image->link = $request->image;
        $image->save();

        return $image;
    }
}
