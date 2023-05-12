<?php 
$file = file_get_contents("compress.zlib://".$file_path);
$data = file_put_contents('1.zip', $file);
