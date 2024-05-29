<?php
include_once('./hnapay.config.php');
$hnapay['data']=$_POST;

$hnapay['sign_str']='';
$hnapay['sign_str'].='version=['.$hnapay['data']['version'].']';
$hnapay['sign_str'].='tranCode=['.$hnapay['data']['tranCode'].']';
$hnapay['sign_str'].='merOrderId=['.$hnapay['data']['merOrderId'].']';
$hnapay['sign_str'].='merId=['.$hnapay['data']['merId'].']';
$hnapay['sign_str'].='charset=['.$hnapay['data']['charset'].']';
$hnapay['sign_str'].='signType=['.$hnapay['data']['signType'].']';
$hnapay['sign_str'].='resultCode=['.$hnapay['data']['resultCode'].']';
$hnapay['sign_str'].='hnapayOrderId=['.$hnapay['data']['hnapayOrderId'].']';

//version=[]tranCode=[]merOrderId=[]merId=[]charset=[]signType=[]resultCode=[]hnapayOrderId=[]

$hnapay['public_rsa']=openssl_get_publickey("-----BEGIN PUBLIC KEY-----\n".wordwrap($hnapay['public_key'], 64, "\n", true)."\n-----END PUBLIC KEY-----");
$hnapay['sign_verify']=(bool)openssl_verify($hnapay['sign_str'], base64_decode($hnapay['data']['signValue']), $hnapay['public_rsa'], version_compare(PHP_VERSION,'5.4.8','>=') ? OPENSSL_ALGO_SHA1 : SHA1);
if($hnapay['sign_verify']){
    exit('RespCode=200');
}else{
    exit('RespCode=500');
}

