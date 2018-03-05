<?php

require 'core/DbManager.php';

$db_manager = new DbManager();
$db_manager->connect('master', [
    'dsn' => 'mysql:dbname=c9;host=localhost',
    'user' => 'root',
]);
$db_manager->getConnection('master');
$db_manager->getConnection();
print_r($db_manager);