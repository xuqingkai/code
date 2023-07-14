<?php
$saeKV = new SaeKV();
$saeKV->init("o626aqSK3MTryEQWrZ4N");
$contents = $saeKV->get('callback');
if($contents===false){
    $contents='';
    $saeKV->add('callback',$contents);
}else{
   
}

$file_path='./callback.txt';
$queryString = $_SERVER['QUERY_STRING'];
if($queryString=='view'){
	//$contents = $saeKV->get('callback');
}else if($queryString=='clear'){
    $saeKV->set('callback', '');
    exit('<script type="text/javascript">window.location.href="?view";</script>');
}else{
	$post_data = file_get_contents('php://input');
	$date_time = date('Y-m-d H:i:s');
	$referer = $_SERVER['HTTP_REFERER']??'';
	$url = $_SERVER['SCRIPT_NAME'].'?'.$_SERVER['QUERY_STRING'];
	$result = $date_time."\r\n".$referer."\r\n".$url."\r\n".$post_data;
	$result .= "\r\n-----------------------------------------------------------------------\r\n";
	$result .= $contents;
	$saeKV->set('callback', $result);;
	$path_info=$_SERVER['PATH_INFO'];
	exit($path_info?substr($path_info,1):"success");	
}?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>通知回调结果</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<body style="font-size:14px;">
	<form>
	<a style="float:right" href="?clear">清空</a><a href="?view">首页</a>
	<textarea style="width:99%;height:500px;font-size:16px;"><?php echo($contents); ?></textarea>
	</form>
</body>
</html>
