<?php
//header('Content-Type: text/html; charset=utf-8');
//error_reporting(0);//都不显示
//error_reporting(E_ALL);//都显示
//date_default_timezone_set('PRC');

//请求地址
$bingzhe['host']='http://jk.hhh2493.cn';
//请求路径
$bingzhe['path']='/api/order/v2/create';
//商户号
$bingzhe['merId']='';
//商户秘钥
$bingzhe['key']='';

$bingzhe['data'] = array();
$bingzhe['data']['contact']='contact';
//$bingzhe['data']['expireTime']='3';
$bingzhe['data']['hrefBackUrl']='http'.($_SERVER["HTTPS"] == 'on' ? 's' : '').'://'.$_SERVER["HTTP_HOST"];
$bingzhe['data']['merId']=$bingzhe['merId'];
$bingzhe['data']['money']=intval('1');
$bingzhe['data']['notifyAddress']='http://moshouh.leyouwow.com/Shoplist/wowoow';
//$bingzhe['data']['notifyAddress']='http://okqq.eu.org/callback/';
$bingzhe['data']['orderNo']=date('YmdHis').rand(1000,9999);
//$bingzhe['data']['payer']='payer';
$bingzhe['data']['payerIp']='127.0.0.1';
$bingzhe['data']['subject']='subject';
$bingzhe['data']['typeCode']='3';//码,1=支付宝，2=微信 3:微信H5,4:支付宝H5
if($bingzhe['data']['typeCode']=='3' || $bingzhe['data']['typeCode']=='4'){
	$bingzhe['data']['sceneType']='Wap';//通道类型为H5时必填(示例值：iOS, Android, Wap)
}

ksort($bingzhe['data']);
$bingzhe['str']='';
foreach($bingzhe['data'] as $key=>$val){ $bingzhe['str'].='&'.$key.'='.$val; }
$bingzhe['str']=substr($bingzhe['str'],1).'&key='.$bingzhe['key'];
$bingzhe['data']['sign']=md5($bingzhe['str']);
$bingzhe['request']=http_build_query($bingzhe['data']);

$bingzhe['url']=$bingzhe['host'].$bingzhe['path'].'?'.htmlspecialchars($bingzhe['request']);

$bingzhe['response']=file_get_contents($bingzhe['host'].$bingzhe['path'], false, stream_context_create(array('http'=>array('method'=>'POST','header'=>"Content-type:application/x-www-form-urlencoded",'content'=>$bingzhe['request']),'ssl'=>array('verify_peer'=>false, 'verify_peer_name'=>false))));
$bingzhe['json']=json_decode($bingzhe['response'], true);
exit(json_encode($bingzhe));
if($bingzhe['json']['code']==200){
	exit('<a href="'.$bingzhe['url'].'">'.$bingzhe['url'].'</a>');
}else{
	exit($bingzhe['json']['msg']);
}

?>
