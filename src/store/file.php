<?php
namespace bloomfilter\store;

/**
 * 用文件实现bit位
 * Created by PhpStorm.
 * User: Jackson.Pei
 * Date: 2020/12/2
 * Time: 15:17
 */

class file implements contract
{
    private $fp;

    public function __construct($file)
    {
        if(!file_exists($file)) {
            file_put_contents($file, '');
        }
        $this->fp = fopen($file, 'rb+');
        if(!$this->fp) {
            throw new \Exception("文件{$file}打开失败");
        }

        if(!flock($this->fp, LOCK_NB | LOCK_EX)) {
            throw new \Exception("获取锁失败");
        }

    }

    function __destruct()
    {
        flock($this->fp, LOCK_UN);
        fclose($this->fp);
        // TODO: Implement __destruct() method.
    }

    public function add($hashArray)
    {
        foreach($hashArray as $hash) {
            $this->setBit($hash);
        }
    }

    public function get($hashArray)
    {
        $bit = array();
        foreach($hashArray as $hash) {
            $bit[] = $this->getBit($hash);
        }
        return $bit;
    }

    /**
     * @param $position
     */
    private function setBit($position) {
        $seek = (int) ($position / 8);
        fseek($this->fp, $seek);
        $char = fread($this->fp, 1);
        $num = $char ? unpack('c', $char) : [1=>0];
        $bit = (8 - $position % 8) % 8;
        $mask = 0x1 << $bit;
        $char = pack('c', $mask | $num[1]);
        fseek($this->fp, $seek);
        return fwrite($this->fp, $char);
    }

    private function getBit($position) {
        $seek = (int) ($position / 8);
        fseek($this->fp, $seek);
        $char = fread($this->fp, 1);
        $num = $char ? unpack('c', $char) : array(1=>0);
        $bit = (8 - $position % 8) % 8;
        $mask = 0x1 << $bit;
        return ($mask & $num[1]) >> $bit;
    }

}