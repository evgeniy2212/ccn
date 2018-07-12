<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 25.08.16
 * Time: 14:28
 */

namespace Core;

use PDO;
use PDOException;

class Db extends PDO {
    private static $dbConn;
    private static $host = 'localhost';
    private static $db = 'ccn_systems';
    private static $user = 'ccn_user';
    private static $pass = '#Q#D-3N+ma]p';

    /**
     * @return PDO
     */
    public static function connect(){
        try {
            self::$dbConn = new PDO('mysql:host=localhost;dbname=ccn_systems',
                self::$user,
                self::$pass,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
            );
            self::$dbConn->exec('SET time_zone = "-4:00";');
            return self::$dbConn;
        } catch (PDOException $e) {
            echo 'Could not connect to the database '.$e->getMessage();
        }
    }

}
/*class Db extends PDO {
    private static $dbConn;
    private static $host = 'kbkarat.mysql.ukraine.com.ua';
    private static $db = 'kbkarat_mcs';
    private static $user = 'kbkarat_mcs';
    private static $pass = 'mw3wf75r';

    public static function connect(){
        try {
            self::$dbConn = new PDO('mysql:host=kbkarat.mysql.ukraine.com.ua;dbname=kbkarat_mcs', self::$user, self::$pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            return self::$dbConn;
        } catch (PDOException $e) {
            echo 'Could not connect to the database '.$e->getMessage();
        }
    }

}/**/