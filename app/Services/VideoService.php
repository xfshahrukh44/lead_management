<?php

namespace App\Services;

use App\Repositories\VideoRepository;
use App\Models\Video;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
// use Hash;

class VideoService extends VideoRepository
{
    public function toggle_video_status($id)
    {
        if(!$video = Video::find($id)){
            return '';
        }

        $video->status = (($video->status == "Inactive") ? ("Active") : "Inactive");
        $video->save();
        return '';
    }
}