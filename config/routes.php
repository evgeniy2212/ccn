<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 25.08.16
 * Time: 14:32
 */
return $routes = array(
    '/' => 'MainController/index',
    '/test/:num/:num' => 'MainController/test/$1/$2',
    '/login' => 'UserController/login',
    '/logout' => 'UserController/logout',
    '/signup' => 'MainController/signUp',
    '/lost-pass' => 'MainController/lostPass',
    '/send-new-pass' => 'UserController/remindPassword',
    '/registration' => 'UserController/saveUser',

    '/banknotes-json' => 'BanknoteController/getJsonWithBanknotesForUser',
    '/cancel-criminal-json' => 'BanknoteController/markChecked',

    '/criminal' => 'BanknoteController/getCriminalBanknotes',
    '/incoming' => 'BanknoteController/getCurrentBanknotes',
    '/temporary' => 'BanknoteController/getTemporaryBanknotes',
    '/criminal-incoming' =>'BanknoteController/getSuspiciousBanknotes',
    '/12-hours-folder' =>'BanknoteController/getBanknotesInQueue',

    '/videos' => 'VideoController/getVideos',
    '/videos/:any/:num' => 'VideoController/playVideo/$1/$2',
    '/videos-for-alarm/:any' => 'VideoController/getVideoForAlarm/$1/$2',

    '/alarm/:any' => 'BanknoteController/showAlarmView/$1',
    '/alarm-all/:any' => 'BanknoteController/showAlarmAllView/$1',
    '/press-alarm/:any' => 'BanknoteController/pressAlarmButton/$1',
    '/press-back-alarm/:any' => 'BanknoteController/pressBackAlarmButton/$1',
    '/undo-alarm/:any' => 'BanknoteController/undoAlarmButton/$1',
    '/undo-last-10hours/:any' => 'BanknoteController/afterTime/$1',
    '/check-time' => 'BanknoteController/timeTmp',
    '/delete-data-db' => 'BanknoteController/deleteDB'


);