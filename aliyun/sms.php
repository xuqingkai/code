<?php
include_once('./config.php');
include_once('./function.php');
function aliyun_sms($PhoneNumbers, $TemplateCode, $TemplateParam, $SignName){
  $req['Action']='SendSms';
  $req['Version']='2017-05-25';
  $req['RegionId']='cn-hangzhou';
  $req['PhoneNumbers']=$PhoneNumbers;
  $req['SignName']=$SignName;
  $req['TemplateCode']=$TemplateCode;
  $req['TemplateParam']=$TemplateParam;
  $res=aliyun_request($req);
  return ;
}
