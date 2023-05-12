<?php
$data='';
$rsa_private_key = '';
$rsa_private = openssl_get_privatekey("-----BEGIN RSA PRIVATE KEY-----\n" . wordwrap($rsa_private_key, 64, "\n", true) . "\n-----END RSA PRIVATE KEY-----");
openssl_private_decrypt($data ,$result ,$rsa_private);
