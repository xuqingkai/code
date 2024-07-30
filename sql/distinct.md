现在需要当前用户表不重复的用户名

select distinct name from userinfo

可是我现在又想得到Id的值，改动如下

select distinct name,id from userinfo

此时distinct同时作用了两个字段，即必须得id与name都相同的才会被排除
