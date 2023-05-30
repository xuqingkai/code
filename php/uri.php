<?php
//请求地址
$url = $_SERVER["REQUEST_SCHEME"].'://'.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
$url = $_SERVER["REQUEST_SCHEME"].'://'.$_SERVER["HTTP_HOST"].$_SERVER["DOCUMENT_URI"].'?'.$_SERVER["QUERY_STRING"];

//请求主机
$host = $_SERVER["REQUEST_SCHEME"].'://'.$_SERVER["HTTP_HOST"];

//请求文件URL
$file_url = $_SERVER["REQUEST_SCHEME"].'://'.$_SERVER["HTTP_HOST"].$_SERVER["SCRIPT_NAME"];

//网站根路径
$root_path = $_SERVER["DOCUMENT_ROOT"];

//执行文件绝对路径
$request_file = $_SERVER["SCRIPT_FILENAME"];

//请求方式
$request_method = $_SERVER["REQUEST_METHOD"];

//DOCUMENT_URI与PHP_SELF区别，前者实际请求什么就是什么，后者如果请求的是/结尾的地址，会附带index.php
?>
