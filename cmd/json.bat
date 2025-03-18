curl -X POST "http://landui.ixqk.cn/callback/Default.ashx/Authorization" ^
 --data-binary "@%~n0.json" ^
 -H "Content-Type: application/json" ^
 -H "Authorization: Bearer YOUR_TOKEN" ^
 --output "%~n0.json.response.log" ^
 --stderr "./error.log"
cmd /k
