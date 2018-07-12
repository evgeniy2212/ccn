<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 10.11.16
 * Time: 10:13
 */

require 'models/DeviceModel.php';
require 'core/Db.php';


$hubs = new \Models\HubModel();
$intervals = $hubs->getIntervalFromLastLogs();

for($i=0;$i<count($intervals);$i++){
    echo $intervals[$i]['period'] . "</br>";
    if($intervals[$i]['period'] > 600){
     $hubs->changeHubToOffline($intervals[$i]['hub_id']);
 }
}


