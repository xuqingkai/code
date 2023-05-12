<?php
if($_FILES["file"]["error"] > 0){
    echo "上传错误: ".$_FILES["file"]["error"]."<br />";
}else{
    foreach($_FILES as $file){
        echo "名称: ".$file["name"] . "<br />";
        echo "类型: ".$file["type"] . "<br />";
        echo "大小: ".$file["size"] / 1024) . " Kb<br />";
        echo "位置: ".$file["tmp_name"] . "<hr />";
    }
}
?>
