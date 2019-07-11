<?php
class UpFtpConfig{
    function get_config(){
         return [
             'imageUpload' => [
                 'uptypes' => [
                     'image/gif',
                     'image/jpg',
                     'image/png',
                     'image/pjpeg',
                     'image/jpeg'
                 ],
                 'image_types' => ['gif','jpg','png','pjpeg','jpeg'],
                 'maxFileSize' => 3145728 //3M = 1024 * 1024 * 3
             ],


             'videoUpload' => [
                 'uptypes' => ['rm','rmvb','mpeg1-4', 'mov', 'mp4', 'mtv', 'dat', 'wmv', 'avi','3gp','amv','dmv','flv'],
                 'maxFileSize' => 1024 * 1024 * 10
             ]
         ];
    }
}



