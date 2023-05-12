//RSA私钥签名
$rsa_private_key = '';
$rsa_private_key = "-----BEGIN RSA PRIVATE KEY-----\n" . wordwrap($private_key, 64, "\n", true) . "\n-----END RSA PRIVATE KEY-----";
$rsa_private = openssl_get_privatekey($rsa_private_key);
openssl_sign($data, $rsa_byte_sign, $rsa_private_key, version_compare(PHP_VERSION,'5.4.8','>=') ? OPENSSL_ALGO_SHA256 : SHA256);
$rsa_sign = base64_encode($rsa_byte_sign);
