<?php
require('./cfg.php');
require('./interface.php');
require('./moder.php');
require('./cons.php');
$diser = new $dis();
$mem = new memcache();
set_time_limit(0);
foreach($ss as $s=>$v){
    $diser->addNode($s);
}


for ($i=1;$i<=1000;$i++){
    $key = 'key_'.$i;
    $val = 'val_'.$i;

    $num = $diser->lookup($key);
//    echo $num;
//        echo $moder->_hash($key).'------>'.$moder->_num.'------>'.(intval($moder->_hash($key))%$moder->_num)."\n";
    $mem->connect($ss[$num]['host'],$ss[$num]['port']);
    $mem->add($key,$val);
    $mem->close();
}

echo "ok";










