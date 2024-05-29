<?php
//接口文档
//https://www.yuque.com/chenyanfei-sjuaz/uhng8q/uoce7b

//网关请求地址
$hnapay['host']='https://gateway.hnapay.com';

//商户编号
//https://portal.hnapay.com/
$hnapay['merId']='';

//报备编号
//https://merchant.hnapay.com
$hnapay['baobei_no']='';

//接口付款公钥
$hnapay['public_key']='';
$hnapay['public_key']=str_replace('-----BEGIN PUBLIC KEY-----','',str_replace('-----END PUBLIC KEY-----','',$hnapay['public_key']));
$hnapay['public_key']=str_replace("\r",'',str_replace("\n",'',$hnapay['public_key']));
//商户私钥
$hnapay['private_key']='';
$hnapay['private_key']=str_replace('-----BEGIN RSA PRIVATE KEY-----','',str_replace('-----END RSA PRIVATE KEY-----','',$hnapay['private_key']));
$hnapay['private_key']=str_replace("\r",'',str_replace("n",'',$hnapay['private_key']));
