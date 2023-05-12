<?php
$laozhao['gateway']='http://send.yyg618.com/chargebank.aspx';
$laozhao['id']='';
$laozhao['key']='';

$laozhao['data']=array();
$laozhao['data']['parter']=$laozhao['id'];
$laozhao['data']['type']='992';
$laozhao['data']['value']='1';
$laozhao['data']['orderid']=date('YmdHis').rand(10000,99999);
$laozhao['data']['callbackurl']='http://cs.yyg618.com/';

$laozhao['str']=''; foreach($laozhao['data'] as $key=>$val){ $laozhao['str'].='&'.$key.'='.$val; }
$laozhao['str']=substr($laozhao['str'],1).$laozhao['key'];
$laozhao['data']['sign']=md5($laozhao['str']);

$laozhao['query']=''; foreach($laozhao['data'] as $key=>$val){ $laozhao['query'].='&'.$key.'='.urlencode($val); }
$laozhao['url']=$laozhao['gateway'].'?'.substr($laozhao['query'],1);

//exit('<a href="'.$laozhao['url'].'">'.$laozhao['url'].'</a>');
header('location: '.$laozhao['url']); exit();
