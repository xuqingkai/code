@echo off

set RULE_NAME=Mysql及web端口
set PORT=3306,8080-8088

netsh advfirewall firewall show rule name=%RULE_NAME% >nul
if not ERRORLEVEL 1 (
    netsh advfirewall firewall delete rule name=%RULE_NAME% >nul
) 

netsh advfirewall firewall add rule name=%RULE_NAME% dir=in action=allow protocol=TCP localport=%PORT%
echo 【%INPUT_RULE_NAME%】 SUCCESS!

pause

