curl -X POST "http://landui.ixqk.cn/callback/" ^
 -F "field1=value1" ^
 -F "field2=value2" ^
 -H "Content-Type: multipart/form-data" ^
 -H "Authorization: Bearer YOUR_TOKEN" ^
 --output "./form.response.log" ^
 --stderr "./error.log"
cmd /k
