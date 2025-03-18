curl -X POST "http://landui.ixqk.cn/callback/" ^
 --data-binary "@%~n0.txt" ^
 -H "Content-Type: multipart/form-data" ^
 -H "Authorization: Bearer YOUR_TOKEN" ^
 --output "%~n0.txt.response.log" ^
 --stderr "./error.log"
cmd /k
