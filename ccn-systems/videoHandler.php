<?
/**
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);

file_put_contents('dump_video.txt', print_r($ar = array(date("H:i:s", time()), $_REQUEST, $_FILES, sys_get_temp_dir()), 1) . file_get_contents('dump_video.txt'));
require 'core/Db.php';
require 'requestHandler/Encryption.php';
require 'models/VideoModel.php';
require 'models/BanknoteModel.php';
if (isset($_REQUEST['key'])) {
    $banknote = new \Models\BanknoteModel();
    $deviceId = $_REQUEST['device_id'];
    $eventTime = $_REQUEST['created_at'];
    $key = $_REQUEST['key'];
    $createAt = $banknote->getLastAlarmToDevice()['created_at'];
    $idAlarmArray = $banknote->getLastAlarmsByCreatedAt($createAt);
    //file_put_contents('dump_video.txt', print_r($idAlarm,1) . file_get_contents('dump_video.txt'));
    $encrypt = new \Handler\Encryption();
    $encrypt = $encrypt->decrypt($key);
    if ($encrypt == $deviceId . $eventTime) {
        $uploaddir = './data/';
        $fileIndex = 0;
        foreach ($_FILES as $uploadFile) {
            $fileIndex++;
            $fullFileName = $uploaddir . $eventTime . ' ' . date("H", time()) . '_' . $fileIndex . '.' . 'mp4';
            file_put_contents('dump_video.txt', print_r($ar = array('-1-', $idAlarmArray, $fullFileName, $deviceId, $eventTime . ' ' . date("H", time()) . '_' . $fileIndex . '.mp4'), 1) . file_get_contents('dump_video.txt'));
            if (move_uploaded_file($uploadFile['tmp_name'], $fullFileName)) {
                foreach ($idAlarmArray as $idAlarm) {
                    file_put_contents('dump_video.txt', print_r($ar = array('-2-', $idAlarm), 1) . file_get_contents('dump_video.txt'));
                    \Models\VideoModel::saveVideos($deviceId, $eventTime . ' ' . date("H", time()) . '_' . $fileIndex . '.mp4', $eventTime, $idAlarm);
                }
                echo "Updated successful\n";
            } else {
                throw new Exception('Unable to load file!');
            }
            if ($fileIndex >= 3) break;
        }
    }
} elseif (isset($_REQUEST['video_request'])) {
    $last_cron_time = file_get_contents("cron . txt");
    $period = time() - 60 * 4;
    if (($last_cron_time < $period)) {
        $videoRequest = '';
        $video = new \Models\VideoModel();
        $banknote = new \Models\BanknoteModel();
        $banknote->addAlarmEvent('1e-00-11-00-19', 'autoalarm', '', '', '1');
        date_default_timezone_set("Europe/Bucharest");
        $lastAlm = time() - 40;
        $lasttime = date('Y-m-d H:i:s', $lastAlm);
        $videoRequest['lastAlarmTime'] = $lasttime;
        echo json_encode($videoRequest);
        file_put_contents("cron . txt", time());
    }
}*/
?><?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 20.02.17
 * Time: 9:09
 */

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);

file_put_contents('dump_video.txt', print_r($ar = array(date("H:i:s", time()), $_REQUEST, $_FILES, sys_get_temp_dir()), 1) . file_get_contents('dump_video.txt'));
require 'core/Db.php';
require 'requestHandler/Encryption.php';
require 'models/VideoModel.php';
require 'models/BanknoteModel.php';

if (isset($_REQUEST['key'])) {
    $banknote = new \Models\BanknoteModel();
    $deviceId = $_REQUEST['device_id'];
    $eventTime = $_REQUEST['created_at'];
    $key = $_REQUEST['key'];
    $createAt = $banknote->getLastAlarmToDevice()['created_at'];
    $idAlarmArray = $banknote->getLastAlarmsByCreatedAt($createAt);

    //file_put_contents('dump_video.txt', print_r($idAlarm,1) . file_get_contents('dump_video.txt'));
    $encrypt = new \Handler\Encryption();
    $encrypt = $encrypt->decrypt($key);
    if ($encrypt == $deviceId . $eventTime) {
        foreach ($_FILES as $uploadFile) {
            if ($uploadFile['error'] > 0)
                die();
        }
        $uploaddir = './data/';
        $fileIndex = 0;
        foreach ($_FILES as $uploadFile) {
            $fileIndex++;
            $fullFileName = $uploaddir . $eventTime . ' ' . date("H:i:s", time()) . '_' . $fileIndex . '.' . 'mp4';
            file_put_contents('dump_video.txt', print_r($ar = array('-1-', $idAlarmArray, $fullFileName, $deviceId, $eventTime . ' ' . date("H:i:s", time()) . '_' . $fileIndex . '.mp4'), 1) . file_get_contents('dump_video.txt'));
            if (move_uploaded_file($uploadFile['tmp_name'], $fullFileName)) {
                foreach ($idAlarmArray as $idAlarm) {
                    file_put_contents('dump_video.txt', print_r($ar = array('-2-', $idAlarm), 1) . file_get_contents('dump_video.txt'));
                    \Models\VideoModel::saveVideos($deviceId, $eventTime . ' ' . date("H:i:s", time()) . '_' . $fileIndex . '.mp4', $eventTime, $idAlarm);
                }
                echo "Updated successful\n";
            } else {
                throw new Exception('Unable to load file!');
            }
            if ($fileIndex >= 3) break;
        }
    }
} elseif (isset($_REQUEST['video_request'])) {
    $videoRequest = '';
    $video = new \Models\VideoModel();
    $banknote = new \Models\BanknoteModel();
// $videoName = $video->getLastVideoNameForDevice($_REQUEST['device_id']);
// $lastVideoTime = substr($videoName, 0,19);
    $lastAutoAlarm = $banknote->getLastAlarmToDevice()['created_at'];
// $lastAlm = substr($lastAutoAlarm, 0,19);

    $videoRequest['lastAlarmTime'] = $lastAutoAlarm;

    echo json_encode($videoRequest);
}/**/