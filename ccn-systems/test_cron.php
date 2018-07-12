<?php
require 'core/Db.php';
require 'requestHandler/Encryption.php';
require 'models/VideoModel.php';
require 'models/BanknoteModel.php';
$eventTime = '2017-07-18 09:15:20';
$banknote = new \Models\BanknoteModel();
$deviceId = '1e-00-11-00-19';
$key = $_REQUEST['key'];
$idAlarm = $banknote->getLastAlarmsByCreatedAt('2017-07-18 09:15:20');

print_r($idAlarm);




