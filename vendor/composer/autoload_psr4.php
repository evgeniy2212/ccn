<?php

// autoload_psr4.php @generated by Composer

$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return array(
    'Notifications\\' => array($baseDir . '/smsGateway'),
    'Models\\' => array($baseDir . '/models'),
    'Handler\\' => array($baseDir . '/requestHandler'),
    'Graph\\' => array($baseDir . '/views/templates'),
    'Core\\' => array($baseDir . '/core'),
    'Controllers\\' => array($baseDir . '/controllers'),
);