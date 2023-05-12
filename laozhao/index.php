<?php
$api_url='http://send.yyg618.com/chargebank.aspx';
$api_id='';
$api_key='';

$data['parter']=$api_id;
$data['type']='992';
$data['value']='1';
$data['orderid']=date('YmdHis').rand(10000,99999);
$data['callbackurl']='http://cs.yyg618.com/';

$str=''; foreach($data as $key=>$val){ $str.='&'.$key.'='.$val; }
$str=substr($str,1).$api_key;
$data['sign']=md5($str);

$str=''; foreach($data as $key=>$val){ $str.='&'.$key.'='.urlencode($val); }

$api_url=$api_url.'?'.substr($str,1);
//exit('<a href="'.$api_url.'">'.$api_url.'</a>');
header('location: '.$api_url); exit();
