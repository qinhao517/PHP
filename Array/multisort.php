<?PHP
//根据售货机安装规格列表从左往右，自上往下的顺序排列商品的bar_code(新增需求)
    $res_bar = array('0000000000082','0000000000089','0000000000099','0000000000021','0000000000020','0000000000019','0000000000014','0000000000006','0000000000005','0000000000007','0000000000001','0000000000010','0000000000009','0000000000013','0000000000015','0000000000017','0000000000016','0000000000004','0000000000003','0000000000023','0000000000055','0000000000088');
    //统计相同商品名称（bar_code）的库存 getShortGoodsList
    foreach ($res as $index => $item) {
        $bar = $item['bar'];
        $index_bar = array_keys($res_bar,$bar);
        $index_bar = $index_bar['0']+1;
        if(in_array("$bar", $res_bar)){
            $res[$index]['sort'] = $index_bar;
        }
    }
    //假设以sort来升叙，我们就需要获取这个字段的值，作为一个新的一维数组。
    $arr1 = array_map(create_function('$n', 'return $n["sort"];'), $res);
    //如果php版本大于 5.5的话，可以直接用 array_column 这个数组操作方法直接获取某个字段，这里也可以通过foreach来获取，但是尽量用内置函数处理。
    //然后就用array_multisort处理，
    array_multisort($arr1,SORT_ASC,$res );
