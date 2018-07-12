<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 20.02.17
 * Time: 14:45
 */

namespace Models;

use Core\View;
use Core\Db;
use PDO;


class BanknoteModel
{
    protected $db;
    private $deviceId;
    private $denomination;
    private $num;
    private $status;
    private $createdAt;


    public function getDeviceId()
    {
        return $this->deviceId;
    }

    public function setDeviceId($deviceId)
    {
        $this->deviceId = $deviceId;
    }

    public function getDenomination()
    {
        return $this->denomination;
    }

    public function setDenomination($denomination)
    {
        $this->denomination = $denomination;
    }

    public function getNum()
    {
        return $this->num;
    }

    public function setNum($num)
    {
        $this->num = $num;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function __construct()
    {
        $this->db = Db::connect();
    }

    public function getAllCriminalBanknotes($f = false)
    {
        $stmt = $this->db->prepare("SELECT num FROM banknotes
WHERE status = '2'" . ($f ? " OR status = '3'" : ""));
        $result = $stmt->execute();
        $banknotes = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return $banknotes;
    }

    public function getDatetimeForLastCriminalBanknote()
    {
        $stmt = $this->db->prepare("SELECT created_at FROM banknotes
WHERE status = '2' ORDER BY created_at DESC LIMIT 1");
        $result = $stmt->execute();
        $datetime = $stmt->fetchColumn();
        return $datetime;
    }

    public function getAllCriminalBanknotesFromDate($dumpDate)
    {
        $stmt = $this->db->prepare("SELECT num, status, created_at FROM banknotes 
WHERE created_at >= '$dumpDate' AND status = '2';");
        $stmt->execute();
        $banknotes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $banknotes;
    }

    public function getAllBanknotesFromMachine($deviceId)
    {
        $stmt = $this->db->prepare("SELECT num, status, created_at FROM banknotes
WHERE device_id = '$deviceId'");
        $stmt->execute();
        $banknotes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $banknotes;
    }

    public function getBanknoteStatus($num)
    {
        $stmt = $this->db->prepare("SELECT status FROM banknotes 
WHERE INSTR('$num', num) > 0 ORDER BY id DESC LIMIT 1");
        $stmt->execute();
        $status = $stmt->fetchColumn();
        return $status;
    }

    public function saveBanknote($deviceId, $num, $status, $mark)
    {
        $stmt = $this->db->prepare('INSERT INTO banknotes(device_id, num, status,mark)
 VALUES(?,?,?,?)');
        $result = $stmt->execute(array($deviceId, $num, $status, $mark));
//        var_dump($result);
    }


    public function getBanknotesForUser($customerId)
    {
        $stmt = $this->db->prepare("SELECT banknotes.device_id,banknotes.num,banknotes.status,banknotes.created_at,statuses.statusText FROM banknotes jOIN devices
ON banknotes.device_id = devices.device_id LEFT JOIN statuses ON statuses.identificator = banknotes.status WHERE devices.customer_id = '$customerId'
UNION
SELECT suspiciousBanknotes.device_id,suspiciousBanknotes.num,suspiciousBanknotes.status,suspiciousBanknotes.created_at,statuses.statusText FROM suspiciousBanknotes jOIN devices
ON suspiciousBanknotes.device_id = devices.device_id LEFT JOIN statuses ON statuses.identificator =suspiciousBanknotes.status WHERE devices.customer_id = '$customerId'
UNION
SELECT temporaryBanknotes.device_id,temporaryBanknotes.num,temporaryBanknotes.status,temporaryBanknotes.created_at,statuses.statusText FROM temporaryBanknotes jOIN devices
ON temporaryBanknotes.device_id = devices.device_id LEFT JOIN statuses ON statuses.identificator = temporaryBanknotes.status
 WHERE devices.customer_id = '$customerId' AND statuses.identificator = temporaryBanknotes.status");
        $stmt->execute();
        $banknotes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $banknotesList['data'] = $banknotes;
        return $banknotesList;
    }

    public function AllBanknotes()
    {
        $stmt = $this->db->prepare("SELECT * FROM banknotes,suspiciousBanknotes,temporaryBanknotes ");
        $stmt->execute();
        $banknotes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $banknotesList['data'] = $banknotes;
        return $banknotesList;
    }

    public function getBanknotesWithCriminalStatus($deviceId)
    {
        $stmt = $this->db->prepare("
SELECT t1.id, t1.device_id, num, status, t1.created_at
FROM
banknotes as t1 JOIN devices t2
ON t1.device_id = t2.device_id
WHERE (t1.status = '2' OR t1.status = '3')
AND t1.device_id = '$deviceId'
ORDER BY id DESC 
");
        $stmt->execute();
        $banknotes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $banknotes;
    }

    public function getBanknotesWithCurrentStatus($deviceId)
    {
        $stmt = $this->db->prepare("
SELECT t1.id, t1.device_id, num, status, t1.created_at
FROM
(SELECT id, device_id, num, status, created_at
FROM banknotes
WHERE created_at IN (
    SELECT MAX(created_at)
    FROM banknotes
    GROUP BY num
)) as t1 JOIN devices t2
ON t1.device_id = t2.device_id
WHERE t1.status = '1' 
AND t1.device_id = '$deviceId'
ORDER BY id DESC
");
        $stmt->execute();
        $banknotes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $banknotes;
    }

    public function getBanknotesWithTemporaryStatus($deviceId)
    {
        $stmt = $this->db->prepare("
SELECT t1.id, t1.device_id, num, status, t1.created_at
FROM
(SELECT id, device_id, num, status, created_at
FROM temporaryBanknotes
WHERE created_at IN (
    SELECT created_at
    FROM temporaryBanknotes
    GROUP BY num
)) as t1 JOIN devices t2
ON t1.device_id = t2.device_id
WHERE t1.status = '0'
AND t1.device_id = '$deviceId'
        ORDER BY created_at DESC 

");
        $stmt->execute();
        $banknotes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $banknotes;
    }

    public function getEveryBanknoteLastEntryForDevice($customerId, $status)
    {
        $stmt = $this->db->prepare("
SELECT t1.id as id, t1.device_id, num, status, t1.created_at
FROM
(SELECT id, device_id, num, status, created_at
    FROM banknotes
    WHERE created_at IN (
        SELECT MAX(created_at)
        FROM banknotes
        GROUP BY num
    )
    AND status = '$status'
) as t1 JOIN devices t2
ON t1.device_id = t2.device_id
WHERE t2.customer_id = '$customerId'
ORDER BY t1.created_at DESC 
");
        $stmt->execute();
        $banknotes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $banknotes;
    }

    public function getEveryCriminalBanknoteLastEntryForDevice($customerId, $status)
    {
        $stmt = $this->db->prepare("
            SELECT t1.id as id, t1.device_id, num, status, t1.created_at,
            alm.id as alarms_id,
            alm.created_at as alarms_created_at,
            alm.type as alarms_type,
            alm.start_id as alarms_start_id,
            alm.end_id as alarms_end_id 
            FROM
            (SELECT id, device_id, num, status, created_at
                FROM banknotes
                WHERE created_at IN (
                    SELECT MAX(created_at)
                    FROM banknotes
                    GROUP BY num
                )
                AND status = '$status'
            ) as t1 JOIN devices t2
            ON t1.device_id = t2.device_id
            LEFT JOIN (SELECT * FROM alarms #WHERE alarms.type = 'autoalarm'
            ORDER BY alarms.id DESC
            ) AS alm ON t1.id>=alm.start_id AND t1.id<=alm.end_id
            WHERE t2.customer_id = '$customerId'
     
            GROUP BY t1.num DESC 
        ");
        $stmt->execute();
        $banknotes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $banknotes;
    }

    public function markAsSuspiciousBanknote($deviceId, $num, $status, $mark)
    {
        $stmt = $this->db->prepare("
                INSERT INTO suspiciousBanknotes(device_id, num, status, mark)
                VALUES (?,?,?,?)
             
        ");

        $stmt->execute(array($deviceId, $num, $status, $mark));
        return $this->db->lastInsertId();
    }


    public function markAsTemporaryBanknote($deviceId, $num, $status, $mark)
    {
        $stmt = $this->db->prepare("
               INSERT INTO temporaryBanknotes(device_id, num, status, mark)
                VALUES (?,?,?,?)
             
        ");

        $stmt->execute(array($deviceId, $num, $status, $mark));
    }

    public function deleteFromIncoming($num, $deviceId)
    {
        $stmt = $this->db->prepare("DELETE FROM banknotes
            WHERE banknotes.num= ?  AND banknotes.device_id = ?");

        $stmt->execute(array($num, $deviceId));
    }

    public function getEverySuspiciousBanknoteLastEntryForDevice($customerId)
    {
        $stmt = $this->db->prepare("
        SELECT suspiciousBanknotes.id, suspiciousBanknotes.device_id, suspiciousBanknotes.num, suspiciousBanknotes.status, suspiciousBanknotes.created_at,
alarms.id AS alm_id, videos.id>0 as vid
        FROM suspiciousBanknotes
        LEFT JOIN devices AS dev ON suspiciousBanknotes.device_id = dev.device_id
        LEFT JOIN alarms ON alarms.id_banknote = suspiciousBanknotes.id
        LEFT JOIN videos ON alarms.id = videos.id_alarm
        WHERE  dev.customer_id = '$customerId'
        GROUP BY suspiciousBanknotes.id 
        ORDER BY created_at DESC 
        ");
        $stmt->execute();
        $banknotes = $stmt->fetchAll(PDO::FETCH_ASSOC);
//        $suspiciousBanknote['data'] = $banknotes;
        return $banknotes;
    }

    public function getBanknoteInQueueForDevice($customerId, $status)
    {
        $stmt = $this->db->prepare("
       SELECT banknotes.id, banknotes.device_id, banknotes.num, banknotes.status, banknotes.created_at,
        timediff(banknotes.updated_at,NOW()-INTERVAL 12 HOUR )  as timeout
        
        FROM banknotes
        
        LEFT JOIN devices AS dev ON banknotes.device_id = dev.device_id
        WHERE banknotes.status = $status AND dev.customer_id =$customerId
        ORDER BY banknotes.created_at DESC 
        ");
        $stmt->execute();
        $banknotes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $banknotes;
    }

    public function markCurrentBanknotesAsCriminal($deviceId)
    {
        $currentBanknotes = $this->getBanknotesWithCurrentStatus($deviceId);
        $start = array_shift($currentBanknotes);
        $end = array_pop($currentBanknotes);
        if ($start) {
            // $this->addAlarmEvent($deviceId, 'add', $start['id'], $end['id']);
            $stmt = $this->db->prepare("
            UPDATE banknotes SET status = '2'
            WHERE status = '1' AND banknotes.device_id = :deviceId 
   
            ");
            $stmt->bindParam(':deviceId', $deviceId);
            $stmt->execute();
            // var_dump(array($deviceId, 'add', $start['id'], $end['id']));
        }
    }


    public function markCriminalBanknotesAsTemporary($id)
    {
        $alarm = $this->getAlarmDetails($id);
        //  var_dump($alarm);
        if ($alarm) {
            $stmt = $this->db->prepare("
        UPDATE banknotes SET status = '0'
        WHERE device_id = ? 
        AND status = '2' 
        AND id BETWEEN ? AND ?
        AND created_at >= ?
");
            var_dump(array($alarm['device_id'], $alarm['start_id'],
                $alarm['end_id'], $alarm['created_at']));
            $result = $stmt->execute(array($alarm['device_id'], $alarm['start_id'],
                $alarm['end_id'], $alarm['created_at']));
            var_dump($result);
            $this->cancelSendingInCriminal($id);
        }
    }

    public function markAsNotCriminal($deviceId)
    {
        $stmt = $this->db->prepare("
           UPDATE banknotes SET status = '1', mark = '0' 
            WHERE created_at IN (
                SELECT created_at FROM(    
                    SELECT MAX(created_at)
                    as created_at
                    FROM banknotes
                    GROUP BY num)as tmp
            ) AND   ( status = '3')  AND banknotes.device_id = :deviceId
            ");
        $stmt->bindParam(':deviceId', $deviceId);
        $stmt->execute();
    }

    public function markCheckedNotCriminal($id)
    {
        $stmt = $this->db->prepare("
           UPDATE banknotes SET status = '1', mark = '0' 
            WHERE banknotes.id = '$id'
            ");
        $stmt->execute();
    }

    public function markAsTMP($deviceId)
    {
        $stmt = $this->db->prepare("            
                UPDATE banknotes SET status = '3', mark = '0'
                WHERE created_at IN (
                    SELECT created_at FROM(    
                        SELECT MAX(created_at)
                        as created_at
                        FROM banknotes AS t1 WHERE t1.device_id = device_id
                        GROUP BY num)as tmp
                ) AND (status = '2'  AND banknotes.device_id = device_id)
            ");
        $stmt->bindParam('deviceId', $deviceId);
        $stmt->execute();
    }

    public function CheckTime()
    {
        $stmt = $this->db->prepare("
               UPDATE banknotes SET status = '1'
                WHERE (((NOW() - updated_at) >=10 )
                      AND status = '3' )
            ");

        $stmt->execute();
    }

    public function cancelSendingInCriminal($id)
    {
        $this->db->query("UPDATE alarms SET type = 'remove'
WHERE id = '$id'");
    }

    public function addAlarmEvent($deviceId, $type, $start, $end, $id)
    {
        $stmt = $this->db->prepare(" SET  time_zone = '+03:00';
INSERT INTO alarms(device_id, type, start_id, end_id, id_banknote)
              VALUES (?,?,?,?,?)
                ");
        $stmt->execute(array($deviceId, $type, $start, $end, $id));

        return $this->db->lastInsertId();
    }

    public function getAllAlarmsForDevice($deviceId, $type = null)
    {
        $q = "SELECT * FROM alarms WHERE device_id = '$deviceId'";
        if (is_string($type))
            $q .= " AND type = '{$type}'";
        $q .= " ORDER BY `created_at`";
        $stmt = $this->db->prepare($q);
        $stmt->execute();
        $alarmList = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $alarmList;
    }

    public function getLastUpdatedBanknotes($deviceId)
    {
        $stmt = $this->db->prepare("SELECT updated_at FROM banknotes
    WHERE device_id = '$deviceId'
    ORDER BY id LIMIT 1;");
        $stmt->execute();
        $time = $stmt->fetchColumn();
        return $time;
    }

    public function getLastUserAlarmForDevice($deviceId)
    {
        $stmt = $this->db->prepare("SELECT max(i d) FROM alarms
WHERE device_id = '$deviceId' AND type = 'add';");
        $stmt->execute();
        $alarmId = $stmt->fetchColumn();
        return $alarmId;
    }


    public function getLastAlarmToDevice()
    {
        $stmt = $this->db->prepare("select  alarms.id,alarms.created_at from alarms 
     where not exists (select videos.id_alarm from videos where videos.id_alarm=alarms.id) 
     ORDER BY alarms.id DESC LIMIT 1
");
        $stmt->execute();
        $alarmId = $stmt->fetch(PDO::FETCH_ASSOC);
        //var_dump($alarmId);
        return $alarmId;

    }

    public function getLastAlarmsByCreatedAt($createdAt)
    {
        $stmt = $this->db->prepare(
            "SELECT alarms.id FROM alarms WHERE alarms.created_at = '$createdAt'"
        );
        $stmt->execute();
        $alarmId = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
        return $alarmId;
    }

    public function getAlarmDetails($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM alarms WHERE id = '$id';");
        $stmt->execute();
        $alarm = $stmt->fetch(PDO::FETCH_ASSOC);
        return $alarm;
    }

}