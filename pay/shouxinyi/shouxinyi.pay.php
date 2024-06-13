<?php
include_once('./shouxinyi.config.php');

$shouxinyi['data']=array();
$shouxinyi['data']['merchantId']=$shouxinyi['merchantId'];
$shouxinyi['data']['orderAmount']=intval('1.00'*100);
$shouxinyi['data']['orderCurrency']='CNY';
$shouxinyi['data']['requestId']=date('YmdHis').rand(1000,9999);
$shouxinyi['data']['notifyUrl']='http://okgo.pp.ua/callback/';
$shouxinyi['data']['callbackUrl']='http://okgo.pp.ua/callback/';
$shouxinyi['data']['paymentModeCode']='BANK_CARD-EXPRESS_DEBIT';
/*
BANK_CARD-EXPRESS_DEBIT快捷支付借记卡
BANK_CARD-EXPRESS_CREDIT快捷支付信用卡
微信支付	
SCANCODE-WEIXIN_PAY-P2P	微信扫码（需要传入clientIp,接收返回的base64编码并解析成二维码图片）
MINIAPPS-WEIXIN_PAY-P2P	微信小程序
WECHAT-OFFICIAL_PAY-P2P	微信公众号
支付宝支付	
SCANCODE-ALI_PAY-P2P	支付宝扫码（需要传入clientIp,接收返回的base64编码并解析成二维码图片）
ALIPAY-WAP-P2P	支付宝H5支付
ALIPAY-OFFICIAL-P2P	支付宝生活号支付
MINIAPPS-ALI_PAY-P2P	支付宝小程序
*/
$shouxinyi['data']['productDetails']=['name'=>'测试商品', 'quantity'=>1, 'amount'=>$shouxinyi['data']['orderAmount']];
$shouxinyi['data']['payer']=['idType'=>'IDCARD'];
$shouxinyi['data']['clientIp']=$_SERVER['REMOTE_ADDR'];
$shouxinyi['data']['merchantUserId']=substr(time().'@'.$_SERVER['HTTP_HOST'],0,30);

$shouxinyi['sign_string'] ='';
ksort($shouxinyi['data']);
foreach ($shouxinyi['data'] as $key=>$val){
    if(!is_array($val)){
        $shouxinyi['sign_string'].=$val.'#';
    }else{
        ksort($val);
        foreach ($val as $key1=>$val1){
            if(!is_array($val1)){
                $shouxinyi['sign_string'].=$val1.'#';
            }else{
                ksort($val1);
                foreach ($val1 as $key2=>$val2){
                    if(!is_array($val2)){
                        $shouxinyi['sign_string'].=$val2.'#';
                    }else{
                        ksort($val2);
                    }
                }
            }
        }
    }
}

openssl_pkcs12_read(file_get_contents($shouxinyi['mch_pfx_file_path']), $shouxinyi['private_rsa'], $shouxinyi['mch_pfx_file_password']);
openssl_sign(sha1($shouxinyi['sign_string'],true), $shouxinyi['data']['hamc'], $shouxinyi['private_rsa']['pkey'], OPENSSL_ALGO_MD5);
$shouxinyi['data']['hamc']=base64_encode($shouxinyi['data']['hamc']);
$shouxinyi['json']=json_encode($shouxinyi['data'], JSON_UNESCAPED_UNICODE);
$shouxinyi['aes_key']=substr(md5($shouxinyi['data']['requestId']),$shouxinyi['data']['orderAmount']%16,16);

$shouxinyi['aes_iv'] = 16 - (strlen($shouxinyi['json']) % 16);
$shouxinyi['data_aes_pad'] = $shouxinyi['json'];
$shouxinyi['data_aes_pad'] .= str_repeat(chr($shouxinyi['aes_iv']), $shouxinyi['aes_iv']);

$shouxinyi['encryptKey'] = openssl_encrypt($shouxinyi['data_aes_pad'], 'AES-128-ECB', $shouxinyi['aes_key'], OPENSSL_RAW_DATA|OPENSSL_ZERO_PADDING);
$shouxinyi['encryptKey'] = base64_encode($shouxinyi['encryptKey']);

$shouxinyi['public_key'] = file_get_contents($shouxinyi['api_cer_file_path']);
if(strpos($shouxinyi['public_key'],'-----') === false){
    $shouxinyi['public_key'] = "-----BEGIN CERTIFICATE-----\n".chunk_split(base64_encode(file_get_contents($shouxinyi['api_cer_file_path'])),64,"\n")."-----END CERTIFICATE-----\n";
}

openssl_public_encrypt($shouxinyi['aes_key'], $shouxinyi['aes_key_encrypted'], openssl_pkey_get_public($shouxinyi['public_key']));
$shouxinyi['aes_key_encrypted']=base64_encode($shouxinyi['aes_key_encrypted']);

$shouxinyi['response_string']=file_get_contents($shouxinyi['host'].'/onlinePay/order', false, stream_context_create(array(
	'http' => array(
		'method' => 'POST',
		'header'  => "Content-Type:application/vnd.5upay-v3.0+json\r\nencryptKey:".$shouxinyi['aes_key_encrypted']."\r\nmerchantId:".$shouxinyi['data']['merchantId']."\r\nrequestId:".$shouxinyi['data']['requestId'],
		'content' => $shouxinyi['json']
	),
	'ssl'=>array(
		'verify_peer'=>false,
		'verify_peer_name'=>false
	)
)));
$shouxinyi['http_response_header']=$http_response_header;
$shouxinyi['decryptKey']='';
foreach ($http_response_header as $header){
   if(strpos($header,'encryptKey:') !== false){
       $shouxinyi['decryptKey']=substr($header,strpos($header,':')+1);
   } 
};
if($shouxinyi['decryptKey']){
    openssl_private_decrypt(base64_decode($shouxinyi['decryptKey']), $shouxinyi['aes_key_decrypted'], openssl_pkey_get_private($shouxinyi['private_rsa']['pkey']));//私钥解密
    $shouxinyi['response_data'] = substr($shouxinyi['response_string'], 9);
    $shouxinyi['response_data'] = substr($shouxinyi['response_data'], 0, strlen($shouxinyi['response_data'])-2);
    $shouxinyi['response_json'] = openssl_decrypt($shouxinyi['response_data'],"AES-128-ECB",$shouxinyi['aes_key_decrypted']);
    $shouxinyi['response_json'] = preg_replace('/[\x00-\x1F]/','', $shouxinyi['response_json']);
    $shouxinyi['response'] = json_decode($shouxinyi['response_json'],true);
    if ($shouxinyi['response']["status"] == 'REDIRECT'){
            header("Location: ".$shouxinyi['response']['redirectUrl']);exit();
    }elseif($shouxinyi['response']["status"] == 'SUCCESS'){
        if(isset($shouxinyi['response']["scanCodeUrl"])){
            exit('<img src="'.$shouxinyi['response']["scanCodeUrl"].'" />');
        }
        if(isset($shouxinyi['response']["scanCode"])){
    		exit('<img src="data:image/jpeg;base64,'.$shouxinyi['response']["scanCode"].'" />');
    		header('Content-type: image/jpg');print_r(base64_decode($shouxinyi['response']["scanCode"]));
        }
	}else{
		//exit($shouxinyi['response_json']);
	}
}
//var_dump($shouxinyi);exit();
header('Content-Type:application/json');
exit(json_encode($shouxinyi, JSON_UNESCAPED_UNICODE));


