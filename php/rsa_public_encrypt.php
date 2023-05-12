<?php
$data = '';
$rsa_public_key = '';

openssl_public_encrypt($data, $result, "-----BEGIN PUBLIC KEY-----\n" . wordwrap($rsa_public_key, 64, "\n", true) . "\n-----END PUBLIC KEY-----");
