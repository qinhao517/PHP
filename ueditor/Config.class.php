<?php

class Config{
    public function get_env_config(){
        $phpenv = strtolower(get_cfg_var("PHPENV"));
        if (!empty($phpenv)) {
            $env = $phpenv;
        } else {
            $env = 'prod';
        }

        $file_path = __DIR__.'/../../../.env_'.$env;
        $file_arr= file($file_path);
        $con_arr = [];
        for($i=0;$i<count($file_arr);$i++){//逐行读取文件内容
            if(!empty($file_arr[$i])){
                $arr1 = explode('=', $file_arr[$i]);
                if(isset($arr1[1])){
                    $arr1[1] = str_replace(array("\r\n", "\r", "\n"), "", $arr1[1]);
                    $con_arr[$arr1[0]] = $arr1[1];
                }
            };
        }

        return $config = [
            'url'=>$con_arr['APP_API_URL'],
            'img_ftp_host'=>'v3.ftp.upyun.com',
            'img_ftp_port'=>21,
            'img_ftp_user'=>'ruigu/ruigustatic',
            'img_ftp_pass'=>'ruigu2008',
            'img_url_prefix'=>'http://static.ruigushop.com'
        ];
    }
}
