<?php

namespace Handler;

use Handler\Crc32;
use Exception;
use Core\Db;
use Models\BanknoteModel;
use PDO;


class DispenserMCS
{
    const DEVICE_ID = 5;
    const CRC32 = 4;
    const TIMESTAMP = 4;
    const BANKNOTE_NUM = 12;
    const PACKET_SIZE = 1024;
    const BANKNOTES_PACKET_SIZE = 1020;


    protected $db;


    public function __construct()
    {
        $this->db = Db::connect();
    }

    private function getInput()
    {
        $handle = fopen('php://input', 'rb');
        if (!$handle) {
            return null;
        }
        $content = stream_get_contents($handle);
        fclose($handle);

        fopen('request.log', 'rb');
        file_put_contents("request.log", $content);

        return $content;
    }


    public function processData()
    {
        $debug = false;

        if (!$debug) {
            $contents = $this->getInput();
            file_put_contents('./log/packetlog_' . time() . '.bin', $contents);
        } else {
            $filename = "./log/test/_packetlog_1497622258.bin";
            $contents = file_get_contents($filename);
        }
        file_put_contents('dump.txt', print_r($ar = array(apache_response_headers(), $contents, $_REQUEST, $_SERVER), 1) . file_get_contents('dump.txt'));

        if (!$contents) {
            header("HTTP/1.1 400 The request is empty");
            return;
        }

        if (isset($_POST['NEED_PAGE'])) {
            session_start();
            $this->updateCriminalListOnDevice();
            die;
        }

        $deviceId = substr($contents, 0, self::DEVICE_ID);
        $data = substr($contents, self::DEVICE_ID, self::CRC32 * (-1));
        $packetChecksum = unpack("Ncheck", strrev(substr($contents, self::CRC32 * (-1))));
//        var_dump($data);
        $checksum = Crc32::getCrc32($deviceId . $data);
        $deviceId = $this->addZero(unpack("C*", $deviceId));
        $deviceId = implode("-", $deviceId);
       // var_dump($data);
       // var_dump($data);
//        var_dump($checksum);
//        var_dump($packetChecksum['check']);
//        if ($packetChecksum['check'] == $checksum){
        if (strlen($data) !== 1) {
            $banknotes = $this->parseBanknotesPackage($data);
            $this->saveBanknotes($deviceId, $banknotes);
//            var_dump([__FILE__.__LINE__,$banknotes]);
//               $this->updateCriminalListOnDevice();
        } else {
            $this->parseCommand($deviceId, $data);
        }
//        }else{
//            header("HTTP/1.1 400 Checksum is incorrect");
//        }

    }

    public function parseBanknotesPackage($data)
    {
        $banknotes = $this->addZero(unpack("C*", $data));
        $banknotes = array_chunk($banknotes, self::BANKNOTE_NUM);
        for ($i = 0; $i < count($banknotes); $i++) {
            $banknotes[$i] = array_map("hexdec", $banknotes[$i]);
            $banknotes[$i] = str_replace(' ', '', $banknotes[$i]);

            $banknotes[$i] = implode("", array_map("chr", $banknotes[$i]));
            if (substr($banknotes[$i], 0, 1) == '0') {
                $banknotes[$i] = substr($banknotes[$i], 1);
            }
//            var_dump($banknotes[$i]);
        }
        return $banknotes;
    }

    public function parseCommand($deviceId, $data)
    {
        $banknote = new BanknoteModel();
        $data = unpack("hcommand", $data);
    //    var_dump($data);
       // die();
        if ($data['command'] == 1) {
            $banknote->markCurrentBanknotesAsCriminal($deviceId);
            header("HTTP/1.1 201 Created");
        } elseif ($data['command'] == 0) {
           // $id = $banknote->getLastUserAlarmForDevice($deviceId);
            $banknote->markAsTMP($deviceId);
            header("HTTP/1.1 201 Created");
        } elseif ($data['command'] == 2) {
            $this->updateCriminalListOnDevice();
            header("HTTP/1.1 201 Created");
        } elseif ($data['command'] == 3) {
          //$banknote->addAlarmEvent($deviceId, 'autoalarm', null, null);
            header("HTTP/1.1 201 Created");
        }
    }

    public function saveBanknotes($deviceId, $banknotes)
    {
        $banknote = new BanknoteModel();
        for ($i = 0; $i < count($banknotes); $i++) {
            $markOfbanknote = (string)(int) substr($banknotes[$i],11);
            $banknotes[$i] = substr($banknotes[$i],0,11);
//            var_dump([__FILE__.__LINE__,$markOfbanknote]);
//            var_dump([__FILE__.__LINE__,$banknotes[$i]]);
            $status = $banknote->getBanknoteStatus($banknotes[$i]);


//            var_dump($status);
//            if ($status == 0 or $status == NULL) {
//                $status = 1;
//             } elseif ($status == 1) {
//                $status = 0;
//            } elseif ($status == 2) {
//                $status = 2;
//            }
//-----проверка по признаку для сохранения
            if($markOfbanknote == '1') {
              // $banknote->saveBanknote($deviceId, $banknotes[$i], 2,$markOfbanknote);

                $id = $banknote->markAsSuspiciousBanknote($deviceId, $banknotes[$i], 4, $markOfbanknote);
               // var_dump($id);
                $banknote->addAlarmEvent($deviceId, 'autoalarm', null, null, $id);
            }elseif($markOfbanknote == '0') {

//---------проверка для добавления во временные
                $banknoteInDB = $banknote->getBanknotesWithCurrentStatus($deviceId);

                $numBanknote = array_column($banknoteInDB, 'num');
//                var_dump([__FILE__.__LINE__,$numBanknote]);
//                var_dump(array($banknotes[$i],$numBanknote));
//                var_dump(in_array($banknotes[$i],$numBanknote));
                    if (in_array($banknotes[$i], $numBanknote)) {

                        $banknote->markAsTemporaryBanknote($deviceId, $banknotes[$i], 0, $markOfbanknote);
                        $banknote->deleteFromIncoming($banknotes[$i], $deviceId);
                    } elseif( preg_match("#^[aA-zZ0-9]{11}$#",$banknotes[$i])) {

                        $banknote->saveBanknote($deviceId, $banknotes[$i], 1, $markOfbanknote);

                    }


            }
        }
        header("HTTP/1.1 201 Created");
    }

    public function updateCriminalListOnDevice()
    {

        if (!isset($_SESSION['header'])) {
            session_start();
            $banknotePackedList = '';
            $banknote = new BanknoteModel();
            $banknoteList = $banknote->getAllCriminalBanknotes(true);
            sort($banknoteList, SORT_STRING);

            //IDENTIFICATOR
            $database = $this->packString('DATABASE');
            //DATETIME
            $datetime = $banknote->getDatetimeForLastCriminalBanknote();
            if ($datetime === false) {
                $datetime = date("Y-m-d H:i:s");
                $datetime = $this->packTime($datetime);
            } else {
                $datetime = $this->packTime($datetime);
            }
            //BANKNOTES PACKAGE
            $banknoteList = $this->packBanknotes($banknoteList);
            //EMPTY PART
            //12232 полный пакет всех купюр 85штук*12страниц*12байт-8байт(на дату и срс32)
            //купюр всегда будет меньше, чем размер пакета, оставшее пространство заполняется нулями

            if (strlen($banknoteList) < 12000) {
                $emptySize = 12000 - strlen($banknoteList);
                $emptyPart = $this->packEmptySpace($emptySize);
                $banknotePackedList .= $emptyPart;
            }

            $banknotePackedList .= $datetime;
            $banknotePackedList .= $this->packChecksum($banknoteList . $banknotePackedList);
            $banknotePackedList .= $this->packEmptySpace(232);


            $_SESSION['header'] = $database . $datetime;
            $_SESSION['banknotes'] = $banknoteList . $banknotePackedList;
//            var_dump(strlen($_SESSION['banknotes']));
//            $page = pack("C*", 0);
//            $banknotes = substr($_SESSION['banknotes'],0, self::BANKNOTES_PACKET_SIZE);
//            $packet = $_SESSION['header'] . $page . $banknotes;
//            $crc32 = $this->packChecksum($packet);
//            echo $packet . $crc32;
        }

        if (isset($_POST['NEED_PAGE'])) {
//            var_dump($_POST['NEED_PAGE']);
            $page = pack("C*", $_POST['NEED_PAGE']);
            $banknotes = substr($_SESSION['banknotes'], $_POST['NEED_PAGE'] * self::BANKNOTES_PACKET_SIZE, self::BANKNOTES_PACKET_SIZE);
            $packet = $_SESSION['header'] . $page . $banknotes;
            $crc32 = $this->packChecksum($packet);
//            var_dump(strlen($packet));
            file_put_contents('dump.txt', print_r($ar = array($packet), 1) . file_get_contents('dump.txt'));
            echo $packet . $crc32;

        } elseif ($_POST['NEED_PAGE'] == 'NONE') {
            session_unset();
            session_destroy();
        }

//        else{
//            session_unset();
//            session_destroy();
//        }
    }

    public function packBanknotes($banknotes)
    {
        foreach ($banknotes as &$value) {
            $value = str_pad($value, 12, ' ', STR_PAD_RIGHT);
        }
        unset($value);
        $banknotes = implode('', $banknotes);
        $banknotes = str_split($banknotes);
        for ($i = 0; $i < count($banknotes); $i++) {
            $banknotes[$i] = ord($banknotes[$i]);
            $banknotes[$i] = pack("C*", $banknotes[$i]);
        }
        $banknotes = implode('', $banknotes);
        return $banknotes;
    }/**/

    public function packString($string)
    {
        $stringArray = str_split($string);
        $stringArrayCount = count($stringArray);
        $result = '';
        for ($i = 0; $i < $stringArrayCount; $i++) {
            $stringArray[$i] = ord($stringArray[$i]);
            $packedString = pack("C*", $stringArray[$i]);
            $result .= $packedString;
        }
        return $result;
    }

    public function packTime($time)
    {
        $packedTime = '';
        $time = \DateTime::createFromFormat("Y-m-d H:i:s O", $time . " +0000");
        $time = $time->getTimestamp();
        $time = dechex($time);
        while (strlen($time) < 8) {
            $time .= '0';
        }
        $time = array_reverse(str_split($time, 2));
        for ($i = 0; $i < 4; $i++) {
            $time[$i] = hexdec($time[$i]);
            $packedPacketParts = pack("C*", $time[$i]);
            $packedTime .= $packedPacketParts;
        }
        return $packedTime;
    }

    public function packChecksum($data)
    {
        $data = Crc32::getCrc32($data);
        $data = dechex($data);
        if (strlen($data) < 8) {
            $data = "0" . $data;
        }
        $dataParts = str_split($data, 2);

        for ($i = 0; $i < count($dataParts); $i++) {
            $dataParts[$i] = pack("C*", hexdec($dataParts[$i]));
        }
        $data = strrev(implode("", $dataParts));
        return $data;
    }

    public function packEmptySpace($emptySize) //for net options that should not be sent
    {
        $packedData = '';
        for ($i = 0; $i < $emptySize; $i++) {
            $packedEmptyChar = pack("C*", 0xff);
            $packedData .= $packedEmptyChar;
        }
        return $packedData;
    }

    //fix bug with zeros
    public function addZero($data)
    {
        $size = count($data) + 1;
        for ($i = 1; $i < $size; $i++) {
            $search = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
            $replace = array('00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '0a', '0b', '0c', '0d', '0e', '0f');
            $data[$i] = dechex($data[$i]);
            if (strlen($data[$i]) < 2) {
                $data[$i] = str_replace($search, $replace, $data[$i]);
            }
        }
        return $data;
    }
    //end fix

}















