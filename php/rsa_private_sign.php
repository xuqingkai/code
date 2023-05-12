<?php
//RSA私钥签名
$data='';
$rsa_private_key = '';

$rsa_private = openssl_get_privatekey("-----BEGIN RSA PRIVATE KEY-----\n" . wordwrap($private_key, 64, "\n", true) . "\n-----END RSA PRIVATE KEY-----");
openssl_sign($data, $rsa_byte_sign, $rsa_private, version_compare(PHP_VERSION,'5.4.8','>=') ? OPENSSL_ALGO_SHA256 : SHA256);

$base64_sign = base64_encode($rsa_byte_sign);
