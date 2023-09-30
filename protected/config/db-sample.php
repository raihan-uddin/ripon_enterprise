<?php
return array(
    'class' => 'system.db.CDbConnection',
    'connectionString' => 'mysql:host=localhost;dbname=tmebd_inventory',
    'emulatePrepare' => true,
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
    'tablePrefix' => '',
//    'schemaCachingDuration' => 1,
    'enableProfiling' => false,
    'enableParamLogging' => true,
    'initSQLs' => array("SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));"),
);