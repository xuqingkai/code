<?php
//请求地址
$url = 'http'.($_SERVER["HTTPS"] == 'on' ? 's' : '').'://'..'://'.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
$url = 'http'.($_SERVER["HTTPS"] == 'on' ? 's' : '').'://'..'://'.$_SERVER["HTTP_HOST"].$_SERVER["DOCUMENT_URI"].'?'.$_SERVER["QUERY_STRING"];

//请求主机
$host = 'http'.($_SERVER["HTTPS"] == 'on' ? 's' : '').'://'..'://'.$_SERVER["HTTP_HOST"];

//请求文件URL
$file_url = 'http'.($_SERVER["HTTPS"] == 'on' ? 's' : '').'://'..'://'.$_SERVER["HTTP_HOST"].$_SERVER["SCRIPT_NAME"];

//网站根路径
$root_path = $_SERVER["DOCUMENT_ROOT"];

//执行文件绝对路径
$request_file = $_SERVER["SCRIPT_FILENAME"];

//请求方式
$request_method = $_SERVER["REQUEST_METHOD"];

//DOCUMENT_URI与PHP_SELF区别，前者实际请求什么就是什么，后者如果请求的是/结尾的地址，会附带index.php
//如请求：/1.php/index/index?dd=2131
//DOCUMENT_URI：/1.php/index/index
//PHP_SELF：/1.php/index/index
  
//如请求：/1.php/index/index/?dd=2131
//DOCUMENT_URI：/1.php/index/index
//PHP_SELF：/1.php/index/index/index.php
?>
