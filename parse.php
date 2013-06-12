<?php

include_once("db.php");

if (isset($argv[1]))
    $area = $argv[1];
else
    $area = 'D:\\thelostatlantis\\area\\area.lst';

$opts = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
$pdo  = new PDO('mysql:dbname=la;host=localhost;charset=utf8', 'root', null, $opts) or die(var_dump($pdo->errorInfo()));



$dir = dirname($area) . '\\';
//dump_area($dir . 'midgaard.are');return;

// load all
emptyTables();
$areas = file($area);
foreach ($areas as $area_file) {
    $area_file = trim($area_file);
    var_dump($area_file);

    if (preg_match('/\w*\.are/', $area_file))
        dump_area($dir . $area_file);
}

echo 'done';
