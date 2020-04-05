<?php


class Cons implements hasher,distribution{
    protected $nodes = [];
    protected $points = [];
    protected $_mul = 64;      //分割成64个虚拟节点

    public function _hash($str)
    {
        return sprintf('%u',crc32($str));
    }


    public function lookup($key)
    {
        $postion = $this->_hash($key);  //算出键落在圆环上的位置
        reset($this->points);
        $neddle = key($this->points);   //拿到第一个key值
        foreach($this->points as $p=>$v){
            if($postion <= $p){
                $neddle = $p;
                break;
            }

        }

        return $this->points[$neddle];
    }

    public function addNode($node){
        $this->nodes[$node] = [];

        for($i=0;$i<$this->_mul;$i++){
            $point = $node . '_' . $i;
            $point = $this->_hash($point);  //虚拟节点转为数字
            $this->points[$point] = $node;
            $this->nodes[$node][] = $point;

            ksort($this->points);  //每次都按键值从大到小排序
        }
    }

    public function delNode($node){
        foreach($this->nodes[$node] as $p){  //清楚虚拟节点
            unset($this->points[$p]);
        }
        unset($this->nodes[$node]);   //删除节点
    }

}


/*
 *      测试一致性哈希算法
 */
//$cons = new cons();
//$cons->addNode('A');
//$cons->addNode('B');
//$cons->addNode('C');
//$cons->addNode('D');
////print_r($cons);
//echo $cons->_hash('name') . 'fall in ' . $cons->lookup('name') . "\n";
//echo $cons->_hash('title') . 'fall in ' . $cons->lookup('name') . "\n";
?>