<?php

/**
 * 批量替换表中某个字段中的特定字符
 * replace(object,search,replace)
 *把object中出现search的全部替换为replace
 */
$sql = "update `ecs_goods` set `goods_name`=replace(`goods_name`,'【包邮】','') WHERE goods_name like '%【包邮】%'";
