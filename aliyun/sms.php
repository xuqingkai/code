<?php
include_once('./config.php');
include_once('./function.php');
function aliyun_sms($PhoneNumbers, $TemplateCode, $TemplateParam, $SignName){
	$dict['Action']='SendSms';
	$dict['Version']='2017-05-25';
	$dict['RegionId']='cn-hangzhou';
	$dict['PhoneNumbers']=$PhoneNumbers;
	$dict['SignName']=$SignName;
	$dict['TemplateCode']=$TemplateCode;
	$dict['TemplateParam']=$TemplateParam;
}
