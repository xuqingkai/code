<?php
$root_host = 'http'.($_SERVER["HTTPS"] == 'on' ? 's' : '').'://'.$_SERVER["HTTP_HOST"];
//请求地址
$request_url = 'http'.($_SERVER["HTTPS"] == 'on' ? 's' : '').'://'.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
//执行文件URL
$file_url = 'http'.($_SERVER["HTTPS"] == 'on' ? 's' : '').'://'.$_SERVER["HTTP_HOST"].$_SERVER["SCRIPT_NAME"];
?>
