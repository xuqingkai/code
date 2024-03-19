<?php
function xpay_useragent_contains($browers){
	$user_agent = $_SERVER["HTTP_USER_AGENT"];
	if($browers == "weixin" && strpos($user_agent, " MicroMessenger/")>0)
	{
		return true;
	}
	elseif($browers == "alipay" && strpos($user_agent, " AlipayClient/")>0)
	{
		return true;
	}
	elseif($browers == "qq" && strpos($user_agent, " QQ/")>0)
	{
		return true; 
	}
	elseif($browers == "mobile" && (strpos($user_agent, "Android")>0 || strpos($user_agent, "iPhone")>0 || strpos($user_agent, "ios")>0 || strpos($user_agent, "iPod")>0))
	{
		return true;
	}
	elseif(strpos($user_agent, $browers)>0)
	{
		return true;
	}
	return false;
}
?>
