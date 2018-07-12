<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 24.02.17
 * Time: 9:48
 */

namespace Controllers;

use Core\View;
use Models\BanknoteModel;
date_default_timezone_set('Europe/Kiev');
class BanknoteController
{

    public static function getJsonWithBanknotesForUser(){
        $banknotes =  new BanknoteModel();
       $banknotes = $banknotes->getBanknotesForUser($_SESSION['id']);
        //$banknotes = $banknotes->getBanknotesForUser();

        echo json_encode($banknotes);
    }

    public static function getCriminalBanknotes(){
        $banknotes =  new BanknoteModel();
        $criminalBanknotes = array();
//        $banknotes = $banknotes->getBanknotesWithCriminalStatus($_SESSION['id']);
        $banknotes = $banknotes->getBanknotesWithCriminalStatus($_SESSION['device_id']);
        /*for ($i=0;$i<count($banknotes);$i++){
            if($banknotes[$i]['status'] == 2){
                array_push($criminalBanknotes, $banknotes[$i]);
            }
        }/**/
        //$criminalBanknotes['title'] = 'Criminal banknotes';
        echo View::render('banknoteList', [
            'title' => 'Criminal banknotes',
            'banknotes' => $banknotes
        ]);
    }
    public static function getSuspiciousBanknotes(){
        $banknotes =  new BanknoteModel();
        $banknotes = $banknotes->getEverySuspiciousBanknoteLastEntryForDevice($_SESSION['id']);

        echo View::render('banknoteList', [
            'title' => 'Incoming criminal banknotes',
            'banknotes' => $banknotes
        ]);
    }
    public static function getBanknotesInQueue(){
        $banknotes =  new BanknoteModel();
        $banknotes = $banknotes->getBanknoteInQueueForDevice($_SESSION['id'], 3);

        echo View::render('banknoteList', [
            'title' => '12 hours folder',
            'banknotes' => $banknotes
        ]);
    }

    public static function getCurrentBanknotes(){
        $banknotes =  new BanknoteModel();
        $criminalBanknotes = array();
//        $banknotes = $banknotes->getBanknotesWithCurrentStatus($_SESSION['id']);
        $banknotes = $banknotes->getEveryBanknoteLastEntryForDevice($_SESSION['id'], 1);
        /*for ($i=0;$i<count($banknotes);$i++){
            if($banknotes[$i]['status'] == 1){
                array_push($criminalBanknotes, $banknotes[$i]);
            }
        }/**/
        //$criminalBanknotes['title'] = 'Current banknotes';
        //echo View::render('banknoteList', $criminalBanknotes);
        echo View::render('banknoteList', [
            'title' => 'Incoming banknotes',
            'banknotes' => $banknotes
        ]);
    }

    public static function getTemporaryBanknotes(){
        $banknotes =  new BanknoteModel();
        $criminalBanknotes = array();
//        $banknotes = $banknotes->getBanknotesWithTemporaryStatus($_SESSION['id']);
        $banknotes = $banknotes->getBanknotesWithTemporaryStatus($_SESSION['device_id']);
        /*for ($i=0;$i<count($banknotes);$i++){
            if($banknotes[$i]['status'] == 0){
                array_push($criminalBanknotes, $banknotes[$i]);
            }
        }/**/
        //$criminalBanknotes['title'] = 'Temporary banknotes';
        //echo View::render('banknoteList', $criminalBanknotes);
        echo View::render('banknoteList', [
            'title' => 'Temporary banknotes',
            'banknotes' => $banknotes
        ]);

    }

    public static function pressAlarmButton($deviceId){
        $banknotes = new BanknoteModel();
        $banknotes->markCurrentBanknotesAsCriminal($deviceId);
        header('Location:  / ');
    }
    public static function pressBackAlarmButton($deviceId){
        $banknotes = new BanknoteModel();
        $banknotes->markAsTMP($deviceId);
        header('Location: /');
    }


    public static function undoAlarmButton($markingCode){
        $banknotes = new BanknoteModel();
        $banknotes->markCriminalBanknotesAsTemporary($markingCode);
        header('Location: /alarm/' . $_SESSION['device_id']);
    }

    public static function showAlarmView($deviceId){
        $banknotes = new BanknoteModel();
        $banknotes = $banknotes->getAllAlarmsForDevice($deviceId, 'add');
        echo View::render('alarmList', $banknotes);
    }

    public static function showAlarmAllView($deviceId){
        $banknotes = new BanknoteModel();
        $banknotes = $banknotes->getAllAlarmsForDevice($deviceId);
        echo View::render('alarmFullList', $banknotes);
    }



    public static function afterTime($deviceId)
    {
//-----------
        $banknote = new  BanknoteModel();
        $banknote->markAsNotCriminal($deviceId);
        header('Location: /');
    }

    public static function timeTmp(){
        $banknote = new BanknoteModel();
        $banknote->CheckTime();
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }

    public static function deleteDB(){
        $db = \Core\Db::connect();
        $db->exec("TRUNCATE TABLE alarms;
        TRUNCATE TABLE banknotes;
        TRUNCATE TABLE videos;
        TRUNCATE TABLE suspiciousBanknotes;
        TRUNCATE TABLE temporaryBanknotes;
        ");
      //  print_r($db->errorInfo());

        header('Location:   /');
    }

    public static function markChecked(){
        $banknote = new BanknoteModel();
        foreach ($_POST['aId'] as $id) {
            $banknote->markCheckedNotCriminal($id);
        }
        header('Location: /');
    }


}