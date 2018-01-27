<?php
/**
 * Created by PhpStorm.
 * User: q
 * Date: 2018/1/27
 * Time: 16:23
 */
/**
 * 主要记录常用的数组函数
 */

/**
 * array_column() 返回输入数组中某个单一列的值。
 */
function array_column(){
    $a = array(
        array(
            'id' => 5698,
            'first_name' => 'Bill',
            'last_name' => 'Gates',
        ),
        array(
            'id' => 4767,
            'first_name' => 'Steve',
            'last_name' => 'Jobs',
        ),
        array(
            'id' => 3809,
            'first_name' => 'Mark',
            'last_name' => 'Zuckerberg',
        )
    );

    $last_names = array_column($a, 'last_name');
    print_r($last_names);
}
/**
 * 输出：
Array
(
[0] => Gates
[1] => Jobs
[2] => Zuckerberg
 */
