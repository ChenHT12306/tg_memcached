<?php
require('./cfg.php');
require('./interface.php');
require('./moder.php');
require('./cons.php');

$diser = new $dis();
$mem = new memcache();
set_time_limit(0);
//根据配置信息添加节点
foreach($ss as $s => $v){
    $diser->addNode($s);
}
//模拟down机  丢失节点
$diser->delNode('C');

$i=0;
while(true){
    $i+=1;
    $key = ($i%1000)+1;   //键从1开始

    $key = 'key_'.$key;
    $num = $diser->lookup($key);

    $mem->connect($ss[$num]['host'],$ss[$num]['port']);
    if(! $mem->get($key)){  //如果缓存取不到就直接写入
        $mem->add($key,'val_'.$i);
    }

    $mem->close();
    usleep(20000);
}
