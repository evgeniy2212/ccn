<?php
require 'core/Db.php';
require 'requestHandler/Encryption.php';
require 'models/VideoModel.php';
require 'models/BanknoteModel.php';
$videoRequest = '';
$video = new \Models\VideoModel();
$banknote = new \Models\BanknoteModel();
date_default_timezone_set("Europe/Bucharest");

 $lastAlm = time();

 $lasttime =  date('Y-m-d H:i:s', $lastAlm) ;

$videoRequest['lastAlarmTime'] = $lasttime;



echo json_encode($videoRequest);
?>