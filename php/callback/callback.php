<?php
$name='callback';
$url=$_SERVER['PATH_INFO'];
$headers=[];
if($url){
    if(strpos($url,'/http:/')!==false || strpos($url,'/https:/')!==false){
        $headers=str_replace('/','',substr($url,0,strpos($url,'/http')));
        $url=str_replace(':/','://',substr($url,strpos($url,'/http')+1));
        $name=explode('/',$url)[2];
    }else{
        $headers=substr($url,1);
        if(strpos($url,'/')!==false){$headers=substr($headers,0,strpos($url,'/'));}
        $url='';
    }
    if($headers){
        $headers=explode('|',str_replace(',','|',$headers));
    }else{
        $headers=[];
    }
}
$file='./'.$name.'.txt';

$data='';
$query=$_SERVER['QUERY_STRING'];

if($query=='view'){
    $data=@file_get_contents($file);
}elseif($query=='clear'){
    @unlink($file);
    exit('<script type="text/javascript">window.location.href="?view";</script>');
}else{
    $response='OK';
    $text="\r\n\r\n";
    $text.=date('Y-m-d H:i:s')."\r\n";
    $text.="-----【URL】------------------------------------------------------------------\r\n";
    $text.=$_SERVER['SCRIPT_NAME'].'?'.$_SERVER['QUERY_STRING']."\r\n";
    if($headers){
        $text.="-----【HEADER】------------------------------------------------------------------\r\n";
        foreach($headers as $k){
            $key=strtoupper('HTTP_'.$k);
            if(isset($_SERVER[$key])){
                $text.= $key." = ".$_SERVER[$key]."\r\n";
            }
        }
    }
    
    $text.="-----【".$_SERVER['REQUEST_METHOD']."】------------------------------------------------------------------\r\n";
    $content=file_get_contents('php://input');
    $text.=$content."\r\n";
    if($url){
        $header=[];
        foreach($headers as $k){
            $key=strtoupper('HTTP_'.$k);
            if(isset($_SERVER[$key])){
                $header[]= strtoupper($k).":".$_SERVER[$key];
            }
        }
        if(!$header){
            $header[]='Content-Type:application/x-www-form-urlencoded';
        }
        $response=file_get_contents($url, false, stream_context_create(array(
        	'http' => array(
        		'method' => $_SERVER['REQUEST_METHOD'],
        		'header'  => implode("\r\n",$header),
        		'content' => $content
        	),
        	'ssl'=>array(
        		'verify_peer'=>false,
        		'verify_peer_name'=>false
        	)
        )));

        $text.="-----【RESPONSE】------------------------------------------------------------------\r\n";
        $text.=$response."\r\n";
    }
    $text.="=======================================================================\r\n";
    $text.=@file_get_contents($file);
    file_put_contents($file, $text);
    exit($response);
}
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Callback</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style type="text/css">
      body{font-size:14px;}
      textarea{width:99%;height:90vh;font-size:16px;}
    </style>
</head>
<body>
    <form>
        <a style="float:right" href="?clear">清空</a><a href="?view">首页</a>
        <textarea><?php echo($data); ?></textarea>
    </form>
</body>
</html>
