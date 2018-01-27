<?php
/**
 * Created by PhpStorm.
 * User: q
 * Date: 2018/1/21
 * Time: 16:23
 */
/**
 * 获取前一个月第一天和最后一天的具体时间
 */
function getlastMonthDays(){
    $timestamp=time();
    $firstday=date('Y-m-01',strtotime(date('Y',$timestamp).'-'.(date('m',$timestamp)-1).'-01'));
    $lastday=date('Y-m-d',strtotime("$firstday +1 month -1 day"));
    $a = array($firstday,$lastday);
    var_dump($a);
}
getlastMonthDays();