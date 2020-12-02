<?php
/**
 * Created by PhpStorm.
 * User: Jackson.Pei
 * Date: 2020/12/2
 * Time: 14:41
 */

namespace bloomfilter\traits;


trait redis
{
    private static $_instance;

    public static function getInstance() {
        if(!self::$_instance) {
            self::$_instance = new \Redis();
            self::$_instance->pconnect('127.0.0.1', 6379);
            self::$_instance->auth('');
        }
        return self::$_instance;
    }


}