<?php
interface hasher{
    public function _hash($str);
}

interface distribution{
    public function lookup($key);
}

class Moder implements hasher,distribution{
    public $_ser = [];
    public $_num = 0;

    public function _hash($str){
        return intval(sprintf('%u',crc32($str)));
    }

    public function lookup($key){
        $index = $this->_hash($key) % $this->_num;
//        $index = bcmod($this->_hash($key),$this->_num);
        return $this->_ser[$index];
    }

    public function addNode($s){
        $this->_ser[] = $s;
        $this->_num += 1;
    }

    public function delNode($s){
        foreach ($this->_ser as $k => $v){
            if($s == $v){
                unset($this->_ser[$k]);
            }
        }
        $this->_num -= 1;

        //索引数组重新排序------自身和自身合并重新编号
        $this->_ser = array_merge($this->_ser);
    }
}

/*
 *  模拟测试取模算法
 */

$moder = new moder();
$moder->addNode('a');
$moder->addNode('b');
$moder->addNode('c');
$moder->addNode('d');

for($i=1;$i<=100;$i++){
    $key = 'key_'.$i;
    echo $key . '--->' .$moder->lookup($key) . "\n";
//    echo $moder->_hash($key).'------>'.$moder->_num.'------>'.(intval($moder->_hash($key))%$moder->_num)."\n";
}
?>