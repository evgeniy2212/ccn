<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 24.02.17
 * Time: 9:54
 */

namespace Controllers;


use Core\View;
use Models\VideoModel;

class VideoController
{

    public static function getVideos(){
        $video = new VideoModel();
        $video = $video->getVideoNamesForUser($_SESSION['id']);
        echo View::render('videoList', $video);
    }

    public static function playVideo($deviceId, $id){
        $video = new VideoModel();
        $video = $video->getVideoNameById($id);
        echo View::render('videoPage', $video);
    }

    public static function getVideoForAlarm($deviceId,$alarmId){

        $video = new VideoModel();
        $video = $video->getVideosForAlarm($deviceId,$alarmId);
        echo View::render('videoByAlarm',$video);
    }

}