<?php
/**
 * Created by PhpStorm.
 * User: Jackson.Pei
 * Date: 2020/12/2
 * Time: 14:35
 * 使用redis bit存储
 */

namespace bloomfilter\store;
use bloomfilter\traits;


class redis implements contract
{

    private $redis = null;
    private $key = 'test:demo';

    use traits\redis;

    function __construct()
    {
        $this->redis = self::getInstance();
    }


    public function add($hashArray)
    {
        foreach ($hashArray as $hash) {
            $this->setBit($hash);
    }
    }

    public function get($hashArray)
    {
        $bit = [];
        foreach ($hashArray as $hash) {
            $bit[] = $this->getBit($hash);
        }
        return $bit;
    }

    public function count() {
        return $this->redis->bitCount($this->key);
    }

    /**
     * 设置bit位
     * @param $position
     */
    private function setBit($position) {
//        var_dump($this->redis->keys('*'));die;
        $this->redis->setBit($this->key, $position, 1);
    }

    /**
     * 获取bit位
     * @param $position
     * @return int
     */
    private function getBit($position) {
        return $this->redis->getBit($this->key, $position);
    }


}