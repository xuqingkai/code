<?php
//用户编号
$duolabao['customerNum'] = '';
//店铺编号
$duolabao['shopNum'] = '';
//机具编号
$duolabao['machineNum'] = '';
//店铺名称
$duolabao['shopName'] = '';
//公钥
$duolabao['accessKey'] = '';
//私钥
$duolabao['secretKey'] = '';
//请求域名
$duolabao['host'] = "https://openapi.duolabao.com";
//请求路径
$duolabao['path'] = "/v1/customer/order/payurl/create";


$duolabao['data']['customerNum']=$duolabao['customerNum'];
$duolabao['data']['shopNum']=$duolabao['shopNum'];
$duolabao['data']['machineNum']=$duolabao['machineNum'];
$duolabao['data']['requestNum']=date('YmdHis').rand(1000,9999);
$duolabao['data']['amount']=number_format("1.00", 2, '.', '');
$duolabao['data']['source']='API';
$duolabao['data']['callbackUrl']='http://okqq.eu.org/callback/';
$duolabao['data']['completeUrl']=$_SERVER["REQUEST_SCHEME"].'://'.$_SERVER["HTTP_HOST"];
$duolabao['request']=json_encode($duolabao['data']);

$duolabao['timestamp']=time().'000';
$duolabao['token_str']='secretKey='.$duolabao['secretKey'].'&timestamp='.$duolabao['timestamp'].'&path='.$duolabao['path'].'&body='.$duolabao['request'];
$duolabao['token'] = strtoupper(sha1($duolabao['token_str']));

$duolabao['response']=file_get_contents($duolabao['host'].$duolabao['path'], false, stream_context_create(array('http'=>array('method'=>'POST','header'=>"Content-type:application/json\r\naccessKey:".$duolabao['accessKey']."\r\ntimestamp:".$duolabao['timestamp']."\r\ntoken:".$duolabao['token'],'content'=>$duolabao['request']),'ssl'=>array('verify_peer'=>false, 'verify_peer_name'=>false))));
$duolabao['json']=json_decode($duolabao['response'], true);
exit(json_encode($duolabao));
if($duolabao['json']['result']!='success'){
    exit($duolabao['json']['result']);
}else{
    header('location:'.$duolabao['json']['data']['url']);exit();
}

?>
