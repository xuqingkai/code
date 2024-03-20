<?php
$data='';
$mode='DES-CBC';//DES-ECB,DES-CBC,DES-CTR,DES-OFB,DES-CFB
$key='';
$padding=''; //OPENSSL_RAW_DATA=1,OPENSSL_ZERO_PADDING=2,OPENSSL_NO_PADDING=3,pkcs5padding = 5
$iv='';
$result=openssl_decrypt(base64_decode($data), $mode, $key, 5, $iv);

?>
