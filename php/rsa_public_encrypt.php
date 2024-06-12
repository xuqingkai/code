<?php
$data = '';
$rsa_public_key = '';

openssl_public_encrypt($data, $result, "-----BEGIN PUBLIC KEY-----\n" . wordwrap($rsa_public_key, 64, "\n", true) . "\n-----END PUBLIC KEY-----");
openssl_public_encrypt($data, $result, openssl_pkey_get_public("-----BEGIN CERTIFICATE-----\n".chunk_split(base64_encode(file_get_contents($cer_path)),64,"\n")."-----END CERTIFICATE-----\n"));
