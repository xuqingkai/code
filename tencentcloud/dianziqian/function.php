<?php
function http_post($json, $header){
    
    $service='essbasic';
    $host=$service.'.tencentcloudapi.com';
    $host=$service.'.test.ess.tencent.cn';//测试环境
    $url='https://'.$host;
    $time=time();
    $date=date('Y-m-d',$time-8*60*60);
    $credential_scope=$date."/".$service."/tc3_request";

    $header=array_merge($header,array('Content-Type'=>'application/json; charset=utf-8','Host'=>strtolower($host),'X-TC-Timestamp'=>$time));
    $sign_str='';
    $sign_str.="POST"."\n";
    $sign_str.="/"."\n";
    $sign_str.=""."\n";
    $sign_str.="content-type:application/json; charset=utf-8\nhost:".strtolower($host)."\nx-tc-action:".strtolower($header['X-TC-Action'])."\n"."\n";
    $sign_str.="content-type;host;x-tc-action"."\n";
    $sign_str.=hash('sha256', $json);
    //return $sign_str;

    $sign_str="TC3-HMAC-SHA256"."\n".$time."\n".$credential_scope."\n".hash('sha256', $sign_str);
    //return $sign_str;

    $secret_key=config('secret_key');
    $secret_date=hash_hmac('sha256', $date, "TC3".$secret_key, true);
    $secret_service=hash_hmac('sha256', $service, $secret_date, true);
    $secret_signkey=hash_hmac('sha256', "tc3_request", $secret_service, true);
    $signature = hash_hmac('sha256', $sign_str, $secret_signkey);
    
    //return $secret_key."\n".$sign_str."\n".$signature."\nbe4f67d323c78ab9acb7395e43c0dbcf822a9cfac32fea2449a7bc7726b770a3";

    $authorization='TC3-HMAC-SHA256 Credential='.config('secret_id').'/'.$credential_scope.', SignedHeaders=content-type;host, Signature='.$signature;
    //return $authorization;
    
    $header['Authorization']=$authorization;
    ksort($header);
    $header_str='';
    foreach($header as $key=>$val){ $header_str.=$key.':'.$val."\r\n"; }
    $header=trim($header_str);
    //return $header."\n".$json;
   
    //return $json.$header;
    $response=file_get_contents($url, false, stream_context_create(array('http'=>array('method'=>'POST','header'=>$header,'content'=>$json),'ssl'=>array('verify_peer'=>false, 'verify_peer_name'=>false))));
    return $response;
}
