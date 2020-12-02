<?php
/**
 * Created by PhpStorm.
 * User: Jackson.Pei
 * Date: 2020/12/2
 * Time: 15:40
 */

require 'vendor/autoload.php';

$hash = new bloomfilter\hash();
$store = new bloomfilter\store\file(__DIR__ . '/urlfilter');
//$store = new bloomfilter\store\redis();

$bloomfilter = new bloomfilter\bloomfilter($hash, $store);

$bloomfilter->add('hello');
var_dump($bloomfilter->exists('hello-2'));