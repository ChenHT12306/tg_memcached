<?php
interface hasher{
    public function _hash($str);
}

interface distribution{
    public function lookup($key);
}
