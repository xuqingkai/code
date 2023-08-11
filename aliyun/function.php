<?php
include_once('./config.php');
function aliyun_request($url, $req){
  ksort($req);
  $data = '';
  foreach ($req as $key => $val){
    $data .= "&" . $key . "=" . str_replace("%7E", "~", str_replace("*", "%2A", str_replace("+", "%20", urlencode($val))));
  }
  $data = "GET&%2F&" . urlencode(substr($data, 1));
  $sign = hash_hmac('sha1', $data, config('AccessKeySecret').'&', true);
  $sign = base64_encode($sign);

  $query = '';
  foreach ($dict as $key => $val){ $query .= "&" . $key . "=" . urlencode($val);}
  $query = substr($query,1);
  $query .= "&Signature=".urlencode($sign);
  $url = $url.'?'.$query;
  return file_get_contents($url);
}
