<?php
//app/Helpers/Comment.php

use App\Comment;
use App\Image;

if ( ! function_exists( 'imageTemplate' ) ) {
    function imageTemplate($postId)
    {

       $images = Image::where('post_id', $postId)->orderBy('position','asc')->get();
        $html = '';
        if ( $images ) {
            foreach ($images as $image) {
                $position = $image->position + 1;
                $html .= '<li data-item="'.$position.'" class="image-item">
                              <div class="image-wrapper">
                                <div class="preview-action">

                                    <span val="'.$position.'" class="image-position" >'.$position.'</span>
                                    <a href="#" class="action-delete-image fa fa-times" data-id="'.$image->id.'"></a>

                                    <a href="#" class="action-update-image  fa fa-undo" data-id="'.$image->id.'"></a>

                                </div>
                                <div class="image">
                                  <img src="'.url('/').$image->link.'">
                                </div>
                              </div>
                            </li>';
            }
        }

        return $html;
    }
}

