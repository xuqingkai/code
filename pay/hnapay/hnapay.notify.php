<?php
include_once('./hnapay.config.php');
$hnapay['data']=$_POST;

$hnapay['sign_str']='';
$hnapay['sign_str'].='tranCode=['.$hnapay['data']['tranCode'].']';
$hnapay['sign_str'].='version=['.$hnapay['data']['version'].']';
$hnapay['sign_str'].='merId=['.$hnapay['data']['merId'].']';
$hnapay['sign_str'].='merOrderNum=['.$hnapay['data']['merOrderNum'].']';
$hnapay['sign_str'].='tranAmt=['.$hnapay['data']['tranAmt'].']';
$hnapay['sign_str'].='submitTime=['.$hnapay['data']['submitTime'].']';
$hnapay['sign_str'].='hnapayOrderId=['.$hnapay['data']['hnapayOrderId'].']';
$hnapay['sign_str'].='tranFinishTime=['.$hnapay['data']['tranFinishTime'].']';
$hnapay['sign_str'].='respCode=['.$hnapay['data']['respCode'].']';
$hnapay['sign_str'].='charset=['.$hnapay['data']['charset'].']';
$hnapay['sign_str'].='signType=['.$hnapay['data']['signType'].']';

openssl_sign($hnapay['sign_str'], $hnapay['data']['signMsg'], "-----BEGIN RSA PRIVATE KEY-----\n" . wordwrap($hnapay['private_key'], 64, "\n", true) . "\n-----END RSA PRIVATE KEY-----", version_compare(PHP_VERSION,'5.4.8','>=') ? OPENSSL_ALGO_SHA1 : SHA1);
//$hnapay['data']['signMsg']=base64_encode($hnapay['data']['signMsg']);
$hnapay['data']['signMsg']=bin2hex($hnapay['data']['signMsg']);
$hnapay['data']['signMsg']=strtoupper($hnapay['data']['signMsg']);

