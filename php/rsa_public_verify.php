<?php //RSA公钥验签
$data='';
$base64_sign='';

$rsa_public_key='';
$rsa_public = openssl_get_publickey("-----BEGIN PUBLIC KEY-----\n" . wordwrap($rsa_public_key, 64, "\n", true) . "\n-----END PUBLIC KEY-----");
$verify = (bool)openssl_verify($data, base64_decode($base64_sign), $rsa_public, version_compare(PHP_VERSION,'5.4.8','>=') ? OPENSSL_ALGO_SHA256 : SHA256);
