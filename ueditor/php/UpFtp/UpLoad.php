<?php

require_once __DIR__.'/../UpFtp/UpFtp.php';
require_once __DIR__ . '/../UpFtp/UpFtpConfig.class.php';
class Upload extends UpFtp{

    public function __construct() {
        parent::__construct();
    }

    /**
     * 上传文件
     * @param string  $path 存储路径
     * @param mixed   $file 需要上传的文件，可以是文件流或者文件内容
     * @param int     $pid  标识id
     * @param boolean $autoMkdir 自动创建目录
     *
     * @return array
     */
    private function _uploadImg($path, $file, $pid = NULL, $autoMkdir = TRUE) {
        //加载配置文件
        $UpFtpConfig = new UpFtpConfig();
        $imageUpload = $UpFtpConfig->get_config();
        $img = $file->getRealPath();   //临时文件的绝对路径
        //检查文件是否存在
        if(!file_exists($img)) {
            return array('code' => 404,'msg' => '指定文件不存在','data'=>['src'=>'']);
        }

        $mimeType = $file->getClientMimeType();
        //检查文件类型
        if (!in_array($mimeType, $imageUpload['uptypes'])){
            return array('code' => 401,'msg' => '文件类型不符!' . $mimeType,'data'=>['src'=>'']);
        }

        $size = $file->getClientSize();
        //检查文件大小
        if ($imageUpload['maxFileSize'] < $size){
            return array('code'=>401,'data'=>'','msg'=>'上传文件太大!','data'=>['src'=>'']);
        }
        
        $prefix = isset($pid) ? md5($pid) : md5(uniqid());
        $name = time().$prefix.rand(100, 999);
        $ext = $file->getClientOriginalExtension();
        $savePath = $path . $name . "." . $ext;

        //上传FTP
        try {
            $result = true;
            $this->up_file($img,$savePath);
        } catch(\Exception $e) {
            $result = false;
        }

        if($result) {
            return array('code'=>200,'msg'=>'上传成功','data'=>['src'=>$savePath]);
        } else {
            return array('code'=>400,'msg'=>'上传失败,网络延迟','data'=>['src'=>'']);
        }
    }

    /**
     * 上传文件
     * @param string  $path 存储路径
     * @param mixed   $file 需要上传的文件，可以是文件流或者文件内容
     * @param int     $pid  标识id
     * @param boolean $autoMkdir 自动创建目录
     *
     * @example 
     *          必填：
     *          $path = '/upload/return/' . date("ym") . '/';
     *          $file = '/tmp/phpdMmDyV';
     *          可选：
     *          $pid  =  1;
     *          $autoMkdir = false;
     *          定义方法，并在方法中调用：
     *          public function upload(UpYunContract $upYunContract) {
     *              $upYunContract->uploadImg($path, $file, $pid, $autoMkdir);
     *          }
     * @return array
     */
    public function uploadImg($path, $file, $pid = NULL, $autoMkdir = TRUE){
        return $this->_uploadImg($path, $file, $pid, $autoMkdir);
    }


    private function _uploadVideo($path, $file, $pid = NULL, $autoMkdir = TRUE) {
        //加载配置文件
        $imageUpload = config('UpFtp.videoUpload');
        $img = $file->getRealPath();   //临时文件的绝对路径
        //检查文件是否存在
        if(!file_exists($img)) {
            return array('code' => 404,'msg' => '指定文件不存在','data'=>['src'=>'']);
        }

        $ext = $file->getClientOriginalExtension();
        //检查文件类型
        if (!in_array($ext, $imageUpload['uptypes'])){
            return array('code' => 401,'msg' => '文件类型不符!' . $ext,'data'=>['src'=>'']);
        }

        $size = $file->getClientSize();
        //检查文件大小
        if ($imageUpload['maxFileSize'] < $size){
            return array('code'=>401,'data'=>'','msg'=>'上传文件太大!','data'=>['src'=>'']);
        }

        $prefix = isset($pid) ? md5($pid) : md5(uniqid());
        $name = time().$prefix.rand(100, 999);
        $savePath = $path . $name . "." . $ext;

        //上传FTP
        try {
            $result = true;
            $this->up_file($img,$savePath);
        } catch(\Exception $e) {
            $result = false;
        }

        if($result) {
            return array('code'=>200,'msg'=>'上传成功','data'=>['src'=>$savePath, 'ext'=>$ext]);
        } else {
            return array('code'=>400,'msg'=>'上传失败,网络延迟','data'=>['src'=>'']);
        }
    }

    /**
     * 上传文件
     * @param string  $path 存储路径
     * @param mixed   $file 需要上传的文件，可以是文件流或者文件内容
     * @param int     $pid  标识id
     * @param boolean $autoMkdir 自动创建目录
     *
     * @example
     *          必填：
     *          $path = '/upload/return/' . date("ym") . '/';
     *          $file = '/tmp/phpdMmDyV';
     *          可选：
     *          $pid  =  1;
     *          $autoMkdir = false;
     *          定义方法，并在方法中调用：
     *          public function upload(UpYunContract $upYunContract) {
     *              $upYunContract->uploadImg($path, $file, $pid, $autoMkdir);
     *          }
     * @return array
     */
    public function uploadVideo($path, $file, $pid = NULL, $autoMkdir = TRUE){
        return $this->_uploadVideo($path, $file, $pid, $autoMkdir);
    }

    public function uploadFtp($path, $savePath, $pid = NULL, $autoMkdir = TRUE) {
        return $this->up_file($path, $savePath);
    }

    public function uploadFile($path, $file, $pid = NULL, $autoMkdir = TRUE){
        //加载配置文件
        $UpFtpConfig = new UpFtpConfig();
        $imageUpload = $UpFtpConfig->get_config()['imageUpload'];
        $videoUpload = $UpFtpConfig->get_config()['videoUpload'];
        $img = $file['tmp_name'];   //临时文件的绝对路径
        //检查文件是否存在
        if(!file_exists($img)) {
            return array('code' => 404,'msg' => '指定文件不存在','data'=>['src'=>'']);
        }

        $ext = explode('.', $file['name'])['1'];
        //检查文件类型
        if (!in_array($ext, $imageUpload['image_types']) && !in_array($ext, $videoUpload['uptypes'])){
            return array('code' => 401,'msg' => '文件类型不符!' . $ext,'data'=>['src'=>'']);
        }

        $size = $file['size'];
        //检查文件大小
        //图片大小判断
        if(in_array($ext, $imageUpload['image_types'])){
            if ($imageUpload['maxFileSize'] < $size){
                return array('code'=>401,'data'=>'','msg'=>'上传文件太大!','data'=>['src'=>'']);
            }
        }
        //视频大小判断
        if(in_array($ext, $videoUpload['uptypes'])){
            if ($videoUpload['maxFileSize'] < $size){
                return array('code'=>401,'data'=>'','msg'=>'上传文件太大!','data'=>['src'=>'']);
            }
        }

        $prefix = isset($pid) ? md5($pid) : md5(uniqid());
        $name = time().$prefix.rand(100, 999);
        $savePath = $path . $name . "." . $ext;

        //上传FTP
        try {
            $result = true;
            $this->up_file($img,$savePath);
        } catch(\Exception $e) {
            $result = false;
        }

        if($result) {
            return array('code'=>200, 'state'=>"SUCCESS", 'url'=>$savePath, 'title'=>$img, 'original'=>$savePath, 'type'=>'.'.$ext, 'size'=>$size);
        } else {
            return array('code'=>400,'msg'=>'上传失败,网络延迟','data'=>['src'=>'']);
        }
    }
}