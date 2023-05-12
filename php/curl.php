<?php
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_HEADER, false);//是否返回headers信息
//curl_setopt($curl, CURLOPT_HTTPHEADER, array('header'=>"Content-type:application/json", 'Content-Length'=>strlen($data)));
curl_setopt($curl, CURLOPT_POST, true);
//curl_setopt($curl, CURLOPT_ENCODING,'gzip');
curl_setopt($curl, CURLOPT_POSTFIELDS , $data);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);//忽略重定向
curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
curl_setopt($curl, CURLOPT_TIMEOUT, 10);
curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
$response = curl_exec($curl);
if($response === false){ $response = 'curl:error:'.curl_error($curl); }
curl_close($curl);
