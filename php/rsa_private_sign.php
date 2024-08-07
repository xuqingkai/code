<?php
//RSA私钥签名
$data='';
$rsa_private_key = trim('');
if(substr($rsa_private_key,0,5)!='----'){
  if(substr($rsa_private_key,' RSA ')===false){
    //转换pkcs
  }
  $rsa_private_key="-----BEGIN RSA PRIVATE KEY-----\r\n" . chunk_split($rsa_private_key, 64) . "-----END RSA PRIVATE KEY-----";
}
//openssl_get_privatekey函数7.2.0已被废弃，建议用openssl_pkey_get_private
$rsa_private = openssl_pkey_get_private("-----BEGIN RSA PRIVATE KEY-----\n" . wordwrap($rsa_private_key, 64, "\n", true) . "\n-----END RSA PRIVATE KEY-----");
openssl_sign($data, $rsa_byte_sign, $rsa_private, version_compare(PHP_VERSION,'5.4.8','>=') ? OPENSSL_ALGO_SHA256 : SHA256);

$base64_sign = base64_encode($rsa_byte_sign);
