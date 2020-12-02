<?php
/**
 * Created by PhpStorm.
 * User: Jackson.Pei
 * Date: 2020/12/2
 * Time: 14:33
 * hash bit存储接口
 */

namespace bloomfilter\store;


interface contract
{
    public function add($hashArray);

    public function get($hashArray);
}