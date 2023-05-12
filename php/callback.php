<?php
$file_path='./callback.txt';
$contents = '';
$queryString = $_SERVER['QUERY_STRING'];
if($queryString=='view'){
    if(is_file($file_path)){ $contents = file_get_contents($file_path); }
}else if($queryString=='clear'){
    if(is_file($file_path)){ unlink($file_path); }
    header('location:?view');exit();
}else{
    $post_data = file_get_contents('php://input');
    $date_time = date('Y-m-d H:i:s');
    $referer = $_SERVER['HTTP_REFERER']??'';
    $url = $_SERVER['SCRIPT_NAME'].'?'.$_SERVER['QUERY_STRING'];
    $result = $date_time."\r\n".$referer."\r\n".$url."\r\n".$post_data;
    $result .="\r\n-----------------------------------------------------------------------\r\n";
    $file=fopen($file_path,"a");
    fwrite($file, $result);
    fclose($file);
    exit($post_data);	
}?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Callback</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style type="text/css">
      body{font-size:14px;}
      textarea{width:99%;height:500px;font-size:16px;}
    </style>
</head>
<body>
    <form>
        <a style="float:right" href="?clear">清空</a><a href="?view">首页</a>
        <textarea><?php echo($contents); ?></textarea>
    </form>
</body>
</html>
