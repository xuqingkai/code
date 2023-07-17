<?php
include_once('./function.php');
CreateConsoleLoginUrl();
function CreateConsoleLoginUrl(){
    $header=array();
    $header['X-TC-Action']='CreateConsoleLoginUrl';
    $header['X-TC-Version']='2021-05-26';

    $data=array();
    $data['Agent']=array();
    $data['Agent']['AppId']=config('appid');
    $data['Agent']['ProxyOrganizationOpenId']='某公司ID';
    $data['Agent']['ProxyOperator']=array();
    $data['Agent']['ProxyOperator']['OpenId']='某人ID';
    //$data['Agent']['ProxyAppId']='';
    $data['ProxyOrganizationName']='某公司';
    $json=json_encode($data);
    return http_post($json, $header);
}
