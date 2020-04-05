<?php
require('./cfg.php');

$get = 0;
$hits = 0;

$mem = new memcache();
foreach($ss as $s){
    $mem->connect($s['host'],$s['port']);
    $info = $mem->getStats();
    $get += $info['cmd_get'];
    $hits += $info['get_hits'];

    $mem->close();
}

if($get == 0){
    echo 1;
}else{
    echo $hits/$get;
}