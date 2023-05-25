<?php
$file=fopen('./header.txt',"a");
foreach($_SERVER as $key=>$val){
	fwrite($file, "【".$key."】\r\n".$val."\r\n-----------------------------------------------------------------------\r\n");
}
fclose($file);
?>
