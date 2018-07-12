<?php

file_put_contents('dump.txt', print_r($ar = array(apache_request_headers()), 1) . substr(file_get_contents('dump.txt'),0,50000));
file_put_contents('dump.txt', print_r($ar = array($_REQUEST), 1) . substr(file_get_contents('dump.txt'),0,50000));
//ini_set('display_errors', E_ALL);
//error_reporting(1);
date_default_timezone_set('Europe/Kiev');
define("IN_PARSER_MODE", "true");

ini_set('display_errors', 0);
error_reporting(E_ALL);

//session_start();

require 'requestHandler/DispenserMCS.php';
require 'requestHandler/Crc32.php';
require 'requestHandler/Encryption.php';
require 'models/BanknoteModel.php';
require 'core/Db.php';

$process = new \Handler\DispenserMCS();

$process->processData();