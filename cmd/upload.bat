curl -X POST "http://lingchuangyun.ixqk.cn/upload/" ^
 -F "file=@upload.png" ^
 -F "field1=value1" ^
 -H "Content-Type: multipart/form-data" ^
 -H "Authorization: Bearer YOUR_TOKEN" ^
 --output "%~n0.response.log" ^
 --stderr "./error.log"
cmd /k