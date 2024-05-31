<?php
/*
{
    "order_id":"202405311147507167",
    "mer_id":"",
    "ret_code":"0000",
    "status":"success"
}
*/
include_once('./ldpay.config.php');
$ldpay['data']=$_POST;
if($ldpay['data']['mer_id']==$ldpay['mer_id']){
    
    exit("success");
}
?>
