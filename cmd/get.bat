curl -X GET "http://landui.ixqk.cn/callback/?a=1" ^
 -H "Content-Type: multipart/form-data" ^
 -H "Authorization: Bearer YOUR_TOKEN" ^
 --output "./get.response.log" ^
 --stderr "./error.log"
cmd /k