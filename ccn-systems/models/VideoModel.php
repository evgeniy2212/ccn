<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 23.02.17
 * Time: 16:19
 */

namespace Models;

use Core\View;
use Core\Db;
use PDO;


class VideoModel
{
    protected $db;
    private $deviceId;
    private $filename;
    private $eventTime;
    private $createdAt;


    public function getDeviceId()
    {
        return $this->deviceId;
    }

    public function setDeviceId($deviceId)
    {
        $this->deviceId = $deviceId;
    }

    public function getFilename()
    {
        return $this->filename;
    }

    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    public function getEventTime()
    {
        return $this->eventTime;
    }

    public function setEventTime($eventTime)
    {
        $this->eventTime = $eventTime;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function __construct() {
        $this->db = Db::connect();
    }

    public function alarmIdInVideo(){
        $stmt = $this->db->prepare("SELECT videos.id_alarm
FROM videos
LEFT JOIN alarms on alarms.id = videos.id_alarm
WHERE alarms.id = videos.id_alarm
GROUP BY videos.id_alarm");
        $stmt->execute();
        $videoAlm = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $videoAlm;
    }

    public function getVideoNameById($id){
        $stmt = $this->db->prepare("SELECT * FROM videos WHERE id = '$id'");
        $stmt->execute();
        $video = $stmt->fetch(PDO::FETCH_ASSOC);
        return $video;
    }
    public function getVideosForAlarm($deviceId,$alarmId){
//        var_dump(array($deviceId,$alarmId));
        $stmt = $this->db->prepare("SELECT suspiciousBanknotes.id as bankId, videos.device_id as dev, suspiciousBanknotes.num as sNum, 
videos.id as vid,videos.created_at as date
FROM suspiciousBanknotes 
LEFT JOIN alarms ON alarms.id_banknote = suspiciousBanknotes.id
LEFT JOIN videos ON videos.id_alarm = alarms.id 
WHERE id_alarm = '$alarmId' AND suspiciousBanknotes.device_id = '$deviceId'");
        $stmt->execute();
        $videos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $videoList['data'] = $videos;
        return $videoList;
    }

    public function getAllVideos(){
        $stmt = $this->db->prepare("SELECT * FROM videos;");
        $stmt->execute();
        $videos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $videos;
    }

    public function alarmForVideo($deviceId){
        $db = Db::connect();
        $alarmId = new BanknoteModel();
        $al = $alarmId->getLastAlarmForDevice($deviceId);
        $tim = $this->getCreatedAt();
        $stmt = $db->prepare("UPDATE videos SET id_alarm ='$al'  

WHERE videos.created_at = '$tim'");

    }

    public static function saveVideos($deviceId, $filename, $eventTime,$idAlarm){
        $db = Db::connect();
        $stmt = $db->prepare("INSERT INTO videos(device_id , filename, event_time, created_at, id_alarm)
VALUES (?, ?, ?, NOW(),?)
");
        //$this->alarmForVideo($deviceId);

        $result = $stmt->execute(array($deviceId, $filename, $eventTime,(int)$idAlarm));
        $stmt->closeCursor();
        $stmt=null;
       //var_dump(array($result,$idAlarm));
        //var_dump($stmt->queryString);
    }

    public function getVideoNamesForDevice($deviceId){
        $stmt = $this->db->prepare("SELECT * FROM videos WHERE device_id = '$deviceId'");
        $stmt->execute();
        $videoNames = $stmt->fetch(PDO::FETCH_ASSOC);
        return $videoNames;
    }



    public function getVideoNamesForUser($userId){
        $stmt = $this->db->prepare("SELECT videos.id, videos.device_id, videos.filename,
devices.installation_city, devices.installatiion_street,devices.installation_house_number, 
videos.created_at,suspiciousBanknotes.num
FROM devices JOIN videos
ON devices.device_id = videos.device_id
LEFT JOIN alarms ON alarms.id = videos.id_alarm
LEFT JOIN suspiciousBanknotes ON suspiciousBanknotes.id = alarms.id_banknote
WHERE devices.customer_id = '$userId';
");
        $stmt->execute();
        $videoNames = $stmt->fetchAll(PDO::FETCH_ASSOC);
      //  var_dump($videoNames);
        return $videoNames;
    }

    public function getLastVideoNameForDevice($deviceId){
        $stmt = $this->db->prepare("SELECT filename FROM videos WHERE device_id = ?
ORDER BY id DESC LIMIT 1");
        $stmt->execute(array($deviceId));
        $videoName = $stmt->fetchColumn();
        return $videoName;
    }

}