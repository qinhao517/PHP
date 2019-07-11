<?php

class UpFtp{
      public $off;             // 返回操作状态(成功/失败) 
      public $conn_id;         // FTP连接 
       
      /** 
      * 方法：FTP连接 
      * @FTP_HOST -- FTP主机 
      * @FTP_PORT -- 端口 
      * @FTP_USER -- 用户名 
      * @FTP_PASS -- 密码 
      */
      public function __construct()
      {
          require_once __DIR__.'/../../Config.class.php';
          $config = new Config();
          $UpFtp = $config->get_env_config();
          $FTP_HOST = $UpFtp['img_ftp_host'];
          $FTP_PORT = $UpFtp['img_ftp_port'];
          $FTP_USER = $UpFtp['img_ftp_user'];
          $FTP_PASS = $UpFtp['img_ftp_pass'];
          $this->conn_id = @ftp_connect($FTP_HOST,$FTP_PORT) or die("FTP服务器连接失败");
          @ftp_login($this->conn_id,$FTP_USER,$FTP_PASS) or die("FTP服务器登陆失败");
          @ftp_pasv($this->conn_id,1); // 打开被动模拟
      } 
      /** 
      * 方法：上传文件 
      * @path  -- 本地路径 
      * @newpath -- 上传路径 
      * @type  -- 若目标目录不存在则新建 
      */
      public function up_file($path,$newpath,$type=true) 
      { 
        if($type) $this->dir_mkdirs($newpath);
        $this->off = @ftp_put($this->conn_id,$newpath,$path,FTP_BINARY);
        if(!$this->off){
          return false;
        }
        return true; 
      }

        /** 
        * 方法：生成目录 
        * @path -- 路径 
        */
      public function dir_mkdirs($path) 
      { 
          $path_arr = explode('/',$path);       // 取目录数组 
          $file_name = array_pop($path_arr);      // 弹出文件名 
          $path_div = count($path_arr);        // 取层数 
         
          foreach($path_arr as $val)          // 创建目录 
          { 
            if(@ftp_chdir($this->conn_id,$val) == FALSE) 
            { 
              $tmp = @ftp_mkdir($this->conn_id,$val); 
              if($tmp == FALSE) 
              { 
                return false; 
              } 
              @ftp_chdir($this->conn_id,$val); 
            } 
          } 
             
          for($i=1;$i<=$path_div;$i++)         // 回退到根 
          { 
            @ftp_cdup($this->conn_id); 
          } 
      } 
      
       
      /** 
      * 方法：关闭FTP连接 
      */
      public function close() 
      { 
        @ftp_close($this->conn_id); 
      }
}
