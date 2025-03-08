@echo off
cd /d %~dp0
C:\Windows\System32\inetsrv\appcmd.exe delete app /app.name:"WebsiteName"
C:\Windows\System32\inetsrv\appcmd.exe add app /site.name:"WebsiteNamee" /applicationPool:"DefaultAppPool" /path:"/" /physicalPath:"%cd%"
cd D:\WWWRoot\Web1
C:\Windows\System32\inetsrv\appcmd.exe add vdir /app.name:"WebsiteName" /path:"/upload" /physicalPath:"%cd%"
start http://localhost/
pause
