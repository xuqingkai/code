:next

C:\Windows\System32\curl.exe -s -f --output ".\curl_%date:~0,4%%date:~5,2%%date:~8,2%%time:~0,2%%time:~3,2%%time:~6,2%.txt" --data-urlencode "keyword=1" "http://www.400537.com/code/callback/"

choice /t 5 /d y /n >nul
 
goto next
