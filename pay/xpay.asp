<script language="JScript" runat="server">    
    Array.prototype.get = function(x) { return this[x]; };  
	function UrlDecode(str) { return decodeURIComponent(str); } 
	//使用时必须这样：Set json = xpay_json_object("")
    function xpay_json_object(strJSON) { return eval("(" + strJSON + ")"); } 
	function xpay_json_query(strJSON){eval("var json=" + strJSON + ";");var query='';for(name in json){query+=name+"="+encodeURIComponent(json[name])+"&";}return query;}   
    function xpay_json_xml(strJSON){eval("var json=" + strJSON + ";");var xml='';for(name in json){xml+="<"+name+"><![CDATA["+json[name]+"]]></"+name+">";}return "<xml>"+xml+"</xml>";}   
</script>
<%
Response.Charset="UTF-8"
Dim xpay_config_data
Set xpay_config_data = Server.CreateObject("Scripting.Dictionary")

'添加配置
Function xpay_config_add(config_key, config_value)
	If xpay_config_data.Exists(config_key) Then
		xpay_config_data(config_key)=config_value
	Else
		Call xpay_config_data.Add(config_key, config_value)
	End If
End Function

'获取配置
Function xpay_config(config_key)
	xpay_config = xpay_config_data(config_key)
End Function

'浏览器状态
Function xpay_useragent_contains(browers)
	Dim userAgent
	userAgent = Request.ServerVariables("HTTP_USER_AGENT")
	If browers = "" AND Instr(userAgent, " MicroMessenger/")>0 Then
		xpay_useragent_contains = true
		Exit Function
	ElseIf browers = "alipay" AND Instr(userAgent, " AlipayClient/")>0 Then
		xpay_useragent_contains = true
		Exit Function
	ElseIf browers = "qq" AND Instr(userAgent, " QQ/")>0 Then
		xpay_useragent_contains = true
		Exit Function
	ElseIf browers = "mobile" AND (Instr(userAgent, "Android")>0 OR Instr(userAgent, "iPhone")>0 OR Instr(userAgent, "ios")>0 OR Instr(userAgent, "iPod")>0) Then
		xpay_useragent_contains = true
		Exit Function
	ElseIf Instr(userAgent, browers)>0 Then
		xpay_useragent_contains = true
		Exit Function
	Else
		xpay_useragent_contains = false
	End If
	xpay_useragent_contains = false
End Function

'获取POST数据
Function xpay_post_data(charset)
	Dim bytes:bytes=Request.BinaryRead(Request.TotalBytes)
	Dim adodbStream:Set adodbStream=Server.CreateObject("Adodb.Stream")
	adodbStream.Type=1
	adodbStream.Open
	adodbStream.Write(bytes)
	adodbStream.Position=0
	adodbStream.Type=2
	If Len(charset) <= 0 Then charset="UTF-8"
	adodbStream.Charset=charset
	xpay_post_data=adodbStream.ReadText
	adodbStream.Close()
	Set adodbStream=Nothing
End Function

'当前目录
Function xpay_root_url(url)
	Dim root_url:root_url="http"
	If(Request.ServerVariables("HTTPS")="on") Then root_url="https"
	root_url=root_url&"://"&Request.ServerVariables("HTTP_HOST")
	If Left(url,1)<>"/" Then 
		root_url = root_url&Request.ServerVariables("SCRIPT_NAME")
		root_url = Left(root_url,InStrRev(root_url,"/"))
	End If
	xpay_root_url=root_url & url
End Function

'XML转ARRAY，使用时请用Set赋值
Function xpay_xml_array(xml)
	Dim array
	Set array=Server.CreateObject("Scripting.Dictionary")

	Dim xmlDom
	Set xmlDom=Server.CreateObject("MicroSoft.XmlDom") 
	xmlDom.LoadXml(xml)
	Dim childNodes
	Set childNodes=xmlDom.documentElement.SelectSingleNode("//xml").ChildNodes
	For Each node in childNodes
		Call array.Add(node.NodeName, node.Text)
	Next
	Set xpay_xml_array = array
End Function

'ARRAY转XML
Function xpay_array_xml(array)
	xpay_array_xml=""
	For Each k In array.Keys
		If Len(array(k))>0 Then xpay_array_xml = xpay_array_xml & "<" & k & "><![CDATA[" & array(k) & "]]></" & k & ">"
    Next
	xpay_array_xml="<xml>" & xpay_array_xml & "</xml>"
End Function

'JSON转ARRAY，使用时请用Set赋值
Function xpay_json_array(json)
	Dim dict:Set dict = Server.CreateObject("Scripting.Dictionary")
	Dim query:query = xpay_json_query(json)
	For Each k_v In Split(query,"&")
		If Instr(k_v, "=") AND Left(k_v, 1) <> "=" Then 
			kv = Split(k_v, "=")
			'Response.Write(kv(1)):Response.End()
			Call dict.Add(kv(0), UrlDecode(kv(1)))
		End If
	Next
	Set xpay_json_array = dict
End Function

'ARRAY转JSON
Function xpay_array_json(array)
	xpay_array_json=""
	For Each k In array.Keys
		If Len(xpay_array_json)>0 Then xpay_array_json=xpay_array_json & ","
		If Len(array(k))>0 Then xpay_array_json = xpay_array_json & """" & k & """:""" & array(k) & """"
    Next
	xpay_array_json="{" & xpay_array_json & "}"
End Function

'MD5签名
Function xpay_array_sign(array, sort, keys)
	Dim data:data = ""
	If sort = True Then
		For Each k In Split(keys,",")
			data = data & "&" & k & "=" & array(k)
		Next
	Else
		Dim arrayKeys:arrayKeys = array.Keys
		If sort = False Then arrayKeys = xpay_key_sort(arrayKeys)
		For Each k In arrayKeys
			If Instr(","&keys&",", ","&k&",")=0 Then
				data = data &"&"&k&"="& array(k)
			End If
		Next
	End If
	If Len(data)>0 Then data = Mid(data, 2, Len(data))
	xpay_array_sign = data
End Function


'请求URL数据
Function xpay_array_request(array)
	Dim request_string
	For Each k In array.Keys
		If Len(array(k))>0 Then request_string = request_string & "&" & k & "=" & Server.UrlEncode(array(k))
    Next
	If Len(request_string)>0 Then request_string = Mid(request_string, 2, Len(request_string))
	xpay_array_request = request_string
End Function

'模拟HTTP,Url地址必须指定到文件名
Function xpay_request(url,data)
	Dim responseText:responseText=""
	Dim ajax:Set ajax=Server.CreateObject("MSXML2.ServerXMLHTTP.3.0")
	ajax.setOption(2) = 13056
	Call ajax.Open("POST",url,False)
	'On error resume next 
	Call ajax.setRequestHeader("Content-Length", Len(data))
	Call ajax.SetRequestHeader("Content-Type","application/x-www-form-urlencoded")
	Call ajax.SetRequestHeader("Accept","text/html")
	Call ajax.SetRequestHeader("X-Requested-With","XMLHttpRequest")
	'If Err.Number<>0 Then
		'Response.Write(Err.Number&Err.Description)
		'Response.End
	'End If
	Call ajax.Send(data)
	If(ajax.ReadyState=4) Then
		Dim adodbStream:Set adodbStream= Server.CreateObject("adodb.stream")
		adodbStream.Type=1
		adodbStream.Mode=3
		adodbStream.Open()
		
		If LenB(ajax.responseBody) > 0 Then
			adodbStream.Write(ajax.responseBody)
			adodbStream.Position=0
			adodbStream.Type=2
			adodbStream.Charset="UTF-8"
			responseText=adodbStream.ReadText
		End If
		adodbStream.Close()
		Set adodbStream=Nothing
	End If
	xpay_request=responseText
End Function

'记录日志
Function xpay_debug(log,path)
	Dim dateTime:dateTime = Year(Now())&"-"&Right("0"&Month(Now()),2)&"-"&Right("0"&Day(Now()),2)
	dateTime = dateTime& " " &Right("0"&Hour(Now()),2)&":"&Right("0"&Minute(Now()),2)&":"&Right("0"&Second(Now()),2)
	Dim texts:texts=""
	texts = texts & "当前时间：" & dateTime & Chr(13)&Chr(10)
	texts = texts & "来源地址：" & Request.ServerVariables("HTTP_REFERER") & Chr(13)&Chr(10)
	texts = texts & "当前地址：" & Request.ServerVariables ("PATH_INFO") & "?" & Request.ServerVariables("QUERY_STRING") & Chr(13)&Chr(10)
	texts = texts & "POST参数："
	For each obj in Request.Form:texts = texts & obj & "=" & Request.Form(obj) & "&":Next
	texts = texts & Chr(13)&Chr(10)
	texts = texts & "调试内容：" & log & Chr(13)&Chr(10)
	texts = texts & "----------" & Chr(13)&Chr(10)
	
	If path= "" Then path = "./log.txt"
	path=Server.MapPath(path)
	
	Dim fso:Set fso = Server.CreateObject("Scripting.FileSystemObject")
	If fso.FileExists(path)=False Then
		Dim file:Set file = fso.CreateTextFile(path,True)
		file.Close()
	End If
	Set fso = Nothing

	Set adodbStream=server.CreateObject("Adodb.Stream")
	adodbStream.Type=2
	adodbStream.Mode=3
	adodbStream.Charset="UTF-8"
	adodbStream.Open()
	adodbStream.LoadFromFile(path)
	contents=adodbStream.ReadText() & contents
	adodbStream.WriteText(contents)
	Call adodbStream.SaveToFile(path,2)
	adodbStream.Flush()
	adodbStream.Close()
	Set adodbStream=Nothing
End Function

Dim XPAY_CONFIG_CONNECTION_STRING
'连接ACCESS数据库
Function xpay_access_connect(mdb)
	If Right(Lcase(mdb),6) = ".accdb" Then
		XPAY_CONFIG_CONNECTION_STRING = "Provider=Microsoft.Jet.OLEDB.12.0;"
	Else
		XPAY_CONFIG_CONNECTION_STRING = "Provider=Microsoft.Jet.OLEDB.4.0;"
	End If
	XPAY_CONFIG_CONNECTION_STRING = XPAY_CONFIG_CONNECTION_STRING & "Data Source=" & Server.MapPath(mdb)
End Function

'连接SQLSERVER数据库
Function xpay_sqlserver_connect(ip, db, id, pw)
	XPAY_CONFIG_CONNECTION_STRING = "Provider=SQLOLEDB;Data Source=" & ip & "; Initial Catalog="& db &"; User ID="& id &"; Password=" & pw
End Function

'执行SQL语句
Function xpay_sql_execute(sql)
	Dim connection:Set connection=Server.CreateObject("Adodb.Connection")
	Call connection.Open(XPAY_CONFIG_CONNECTION_STRING)
	Dim recordSet:Set recordSet=Server.CreateObject("Adodb.RecordSet")
	Call recordSet.open(sql,connection,2,3)
	Set xpay_sql_execute=recordSet
End Function

'请求转数组，使用时请用Set赋值
Function xpay_request_array()
	Dim dict:Set dict=Server.CreateObject("Scripting.Dictionary")
	For Each k In Request.QueryString
		Call dict.Add(k,Request.QueryString(k))
	Next

	If dict.Count=0 Then
		For Each k In Request.Form
			Call dict.Add(k,Request.Form(k))
		Next
	End If
	Set xpay_request_array=dict
End Function

'ASCII排序
Function xpay_key_sort(array)
    Dim bound
    bound = UBound(array)
    Dim bSorted, i, t
    bSorted = False
    Do While bound > 0 And bSorted = False  
        bSorted = True
        For i = 0 To bound-1
            If array(i) > array(i+1) Then
                t = array(i)
                array(i) = array(i+1)
                array(i+1) = t
                bSorted = False
            End If
        Next
        bound = bound - 1
    Loop
    xpay_key_sort = array
End Function

'MD5加密
Function xpay_md5(str)
	Dim x,k,AA,BB,CC,DD,a,b,c,d,S11,S12,S13,S14,S21,S22,S23,S24,S31,S32,S33,S34,S41,S42,S43,S44
	S11=7:S12=12:S13=17:S14=22:S21=5:S22=9:S23=14:S24=20:S31=4:S32=11:S33=16:S34=23:S41=6:S42=10:S43=15:S44=21
	x = xpay_md5WordArray(xpay_md5ToAnsi(str))
	a = &H67452301
	b = &HEFCDAB89
	c = &H98BADCFE
	d = &H10325476

	For k = 0 To UBound(x) Step 16
		AA = a
		BB = b
		CC = c
		DD = d

		xpay_md5FF a, b, c, d, x(k + 0), S11, &HD76AA478
		xpay_md5FF d, a, b, c, x(k + 1), S12, &HE8C7B756
		xpay_md5FF c, d, a, b, x(k + 2), S13, &H242070DB
		xpay_md5FF b, c, d, a, x(k + 3), S14, &HC1BDCEEE
		xpay_md5FF a, b, c, d, x(k + 4), S11, &HF57C0FAF
		xpay_md5FF d, a, b, c, x(k + 5), S12, &H4787C62A
		xpay_md5FF c, d, a, b, x(k + 6), S13, &HA8304613
		xpay_md5FF b, c, d, a, x(k + 7), S14, &HFD469501
		xpay_md5FF a, b, c, d, x(k + 8), S11, &H698098D8
		xpay_md5FF d, a, b, c, x(k + 9), S12, &H8B44F7AF
		xpay_md5FF c, d, a, b, x(k + 10), S13, &HFFFF5BB1
		xpay_md5FF b, c, d, a, x(k + 11), S14, &H895CD7BE
		xpay_md5FF a, b, c, d, x(k + 12), S11, &H6B901122
		xpay_md5FF d, a, b, c, x(k + 13), S12, &HFD987193
		xpay_md5FF c, d, a, b, x(k + 14), S13, &HA679438E
		xpay_md5FF b, c, d, a, x(k + 15), S14, &H49B40821

		xpay_md5GG a, b, c, d, x(k + 1), S21, &HF61E2562
		xpay_md5GG d, a, b, c, x(k + 6), S22, &HC040B340
		xpay_md5GG c, d, a, b, x(k + 11), S23, &H265E5A51
		xpay_md5GG b, c, d, a, x(k + 0), S24, &HE9B6C7AA
		xpay_md5GG a, b, c, d, x(k + 5), S21, &HD62F105D
		xpay_md5GG d, a, b, c, x(k + 10), S22, &H2441453
		xpay_md5GG c, d, a, b, x(k + 15), S23, &HD8A1E681
		xpay_md5GG b, c, d, a, x(k + 4), S24, &HE7D3FBC8
		xpay_md5GG a, b, c, d, x(k + 9), S21, &H21E1CDE6
		xpay_md5GG d, a, b, c, x(k + 14), S22, &HC33707D6
		xpay_md5GG c, d, a, b, x(k + 3), S23, &HF4D50D87
		xpay_md5GG b, c, d, a, x(k + 8), S24, &H455A14ED
		xpay_md5GG a, b, c, d, x(k + 13), S21, &HA9E3E905
		xpay_md5GG d, a, b, c, x(k + 2), S22, &HFCEFA3F8
		xpay_md5GG c, d, a, b, x(k + 7), S23, &H676F02D9
		xpay_md5GG b, c, d, a, x(k + 12), S24, &H8D2A4C8A

		xpay_md5HH a, b, c, d, x(k + 5), S31, &HFFFA3942
		xpay_md5HH d, a, b, c, x(k + 8), S32, &H8771F681
		xpay_md5HH c, d, a, b, x(k + 11), S33, &H6D9D6122
		xpay_md5HH b, c, d, a, x(k + 14), S34, &HFDE5380C
		xpay_md5HH a, b, c, d, x(k + 1), S31, &HA4BEEA44
		xpay_md5HH d, a, b, c, x(k + 4), S32, &H4BDECFA9
		xpay_md5HH c, d, a, b, x(k + 7), S33, &HF6BB4B60
		xpay_md5HH b, c, d, a, x(k + 10), S34, &HBEBFBC70
		xpay_md5HH a, b, c, d, x(k + 13), S31, &H289B7EC6
		xpay_md5HH d, a, b, c, x(k + 0), S32, &HEAA127FA
		xpay_md5HH c, d, a, b, x(k + 3), S33, &HD4EF3085
		xpay_md5HH b, c, d, a, x(k + 6), S34, &H4881D05
		xpay_md5HH a, b, c, d, x(k + 9), S31, &HD9D4D039
		xpay_md5HH d, a, b, c, x(k + 12), S32, &HE6DB99E5
		xpay_md5HH c, d, a, b, x(k + 15), S33, &H1FA27CF8
		xpay_md5HH b, c, d, a, x(k + 2), S34, &HC4AC5665

		xpay_md5II a, b, c, d, x(k + 0), S41, &HF4292244
		xpay_md5II d, a, b, c, x(k + 7), S42, &H432AFF97
		xpay_md5II c, d, a, b, x(k + 14), S43, &HAB9423A7
		xpay_md5II b, c, d, a, x(k + 5), S44, &HFC93A039
		xpay_md5II a, b, c, d, x(k + 12), S41, &H655B59C3
		xpay_md5II d, a, b, c, x(k + 3), S42, &H8F0CCC92
		xpay_md5II c, d, a, b, x(k + 10), S43, &HFFEFF47D
		xpay_md5II b, c, d, a, x(k + 1), S44, &H85845DD1
		xpay_md5II a, b, c, d, x(k + 8), S41, &H6FA87E4F
		xpay_md5II d, a, b, c, x(k + 15), S42, &HFE2CE6E0
		xpay_md5II c, d, a, b, x(k + 6), S43, &HA3014314
		xpay_md5II b, c, d, a, x(k + 13), S44, &H4E0811A1
		xpay_md5II a, b, c, d, x(k + 4), S41, &HF7537E82
		xpay_md5II d, a, b, c, x(k + 11), S42, &HBD3AF235
		xpay_md5II c, d, a, b, x(k + 2), S43, &H2AD7D2BB
		xpay_md5II b, c, d, a, x(k + 9), S44, &HEB86D391

		a = xpay_md5AddUnsigned(a, AA)
		b = xpay_md5AddUnsigned(b, BB)
		c = xpay_md5AddUnsigned(c, CC)
		d = xpay_md5AddUnsigned(d, DD)
	Next
	xpay_md5 = LCase(xpay_md5WordToHex(a) & xpay_md5WordToHex(b) & xpay_md5WordToHex(c) & xpay_md5WordToHex(d))
End Function

Function xpay_md5lOnBits(i)
	Dim Arr(30)
	Arr(0) = CLng(1)
	Arr(1) = CLng(3)
	Arr(2) = CLng(7)
	Arr(3) = CLng(15)
	Arr(4) = CLng(31)
	Arr(5) = CLng(63)
	Arr(6) = CLng(127)
	Arr(7) = CLng(255)
	Arr(8) = CLng(511)
	Arr(9) = CLng(1023)
	Arr(10) = CLng(2047)
	Arr(11) = CLng(4095)
	Arr(12) = CLng(8191)
	Arr(13) = CLng(16383)
	Arr(14) = CLng(32767)
	Arr(15) = CLng(65535)
	Arr(16) = CLng(131071)
	Arr(17) = CLng(262143)
	Arr(18) = CLng(524287)
	Arr(19) = CLng(1048575)
	Arr(20) = CLng(2097151)
	Arr(21) = CLng(4194303)
	Arr(22) = CLng(8388607)
	Arr(23) = CLng(16777215)
	Arr(24) = CLng(33554431)
	Arr(25) = CLng(67108863)
	Arr(26) = CLng(134217727)
	Arr(27) = CLng(268435455)
	Arr(28) = CLng(536870911)
	Arr(29) = CLng(1073741823)
	Arr(30) = CLng(2147483647)
	xpay_md5lOnBits=Arr(i)
End Function

Function xpay_md5l2Power(i)
	Dim Arr(30)
	Arr(0) = CLng(1)
	Arr(1) = CLng(2)
	Arr(2) = CLng(4)
	Arr(3) = CLng(8)
	Arr(4) = CLng(16)
	Arr(5) = CLng(32)
	Arr(6) = CLng(64)
	Arr(7) = CLng(128)
	Arr(8) = CLng(256)
	Arr(9) = CLng(512)
	Arr(10) = CLng(1024)
	Arr(11) = CLng(2048)
	Arr(12) = CLng(4096)
	Arr(13) = CLng(8192)
	Arr(14) = CLng(16384)
	Arr(15) = CLng(32768)
	Arr(16) = CLng(65536)
	Arr(17) = CLng(131072)
	Arr(18) = CLng(262144)
	Arr(19) = CLng(524288)
	Arr(20) = CLng(1048576)
	Arr(21) = CLng(2097152)
	Arr(22) = CLng(4194304)
	Arr(23) = CLng(8388608)
	Arr(24) = CLng(16777216)
	Arr(25) = CLng(33554432)
	Arr(26) = CLng(67108864)
	Arr(27) = CLng(134217728)
	Arr(28) = CLng(268435456)
	Arr(29) = CLng(536870912)
	Arr(30) = CLng(1073741824)
	xpay_md5l2Power=Arr(i)
End Function

Function xpay_md5LShift(v, b)
	If b = 0 Then
		xpay_md5LShift = v
		Exit Function
	ElseIf b = 31 Then
		If v And 1 Then
			xpay_md5LShift = &H80000000
		Else
			xpay_md5LShift = 0
		End If
		Exit Function
	ElseIf b < 0 Or b > 31 Then
		Err.Raise 6
	End If

	If (v And xpay_md5l2Power(31 - b)) Then
		xpay_md5LShift = ((v And xpay_md5lOnBits(31 - (b + 1))) * xpay_md5l2Power(b)) Or &H80000000
	Else
		xpay_md5LShift = ((v And xpay_md5lOnBits(31 - b)) * xpay_md5l2Power(b))
	End If
End Function

Function xpay_md5RShift(v, b)
	If b = 0 Then
		xpay_md5RShift = v
		Exit Function
	ElseIf b = 31 Then
		If v And &H80000000 Then
			xpay_md5RShift = 1
		Else
			xpay_md5RShift = 0
		End If
		Exit Function
	ElseIf b < 0 Or b > 31 Then
		Err.Raise 6
	End If

	xpay_md5RShift = (v And &H7FFFFFFE) \ xpay_md5l2Power(b)

	If (v And &H80000000) Then xpay_md5RShift = (xpay_md5RShift Or (&H40000000 \ xpay_md5l2Power(b - 1)))
End Function

Function xpay_md5RotateLeft(v, b)
	xpay_md5RotateLeft = xpay_md5LShift(v, b) Or xpay_md5RShift(v, (32 - b))
End Function

Function xpay_md5AddUnsigned(lX, lY)
	Dim lX4,lY4,lX8,lY8,lR

	lX8 = lX And &H80000000
	lY8 = lY And &H80000000
	lX4 = lX And &H40000000
	lY4 = lY And &H40000000

	lR = (lX And &H3FFFFFFF) + (lY And &H3FFFFFFF)

	If lX4 And lY4 Then
		lR = lR Xor &H80000000 Xor lX8 Xor lY8
	ElseIf lX4 Or lY4 Then
		If lR And &H40000000 Then
			lR = lR Xor &HC0000000 Xor lX8 Xor lY8
		Else
			lR = lR Xor &H40000000 Xor lX8 Xor lY8
		End If
	Else
		lR = lR Xor lX8 Xor lY8
	End If

	xpay_md5AddUnsigned = lR
End Function

Function xpay_md5F(x, y, z)
	xpay_md5F = (x And y) Or ((Not x) And z)
End Function
Function xpay_md5G(x, y, z)
	xpay_md5G = (x And z) Or (y And (Not z))
End Function
Function xpay_md5H(x, y, z)
	xpay_md5H = (x Xor y Xor z)
End Function
Function xpay_md5I(x, y, z)
	xpay_md5I = (y Xor (x Or (Not z)))
End Function

Sub xpay_md5FF(a, b, c, d, x, s, ac)
	a = xpay_md5AddUnsigned(a, xpay_md5AddUnsigned(xpay_md5AddUnsigned(xpay_md5F(b, c, d), x), ac))
	a = xpay_md5RotateLeft(a, s)
	a = xpay_md5AddUnsigned(a, b)
End Sub

Sub xpay_md5GG(a, b, c, d, x, s, ac)
	a = xpay_md5AddUnsigned(a, xpay_md5AddUnsigned(xpay_md5AddUnsigned(xpay_md5G(b, c, d), x), ac))
	a = xpay_md5RotateLeft(a, s)
	a = xpay_md5AddUnsigned(a, b)
End Sub

Sub xpay_md5HH(a, b, c, d, x, s, ac)
	a = xpay_md5AddUnsigned(a, xpay_md5AddUnsigned(xpay_md5AddUnsigned(xpay_md5H(b, c, d), x), ac))
	a = xpay_md5RotateLeft(a, s)
	a = xpay_md5AddUnsigned(a, b)
End Sub

Sub xpay_md5II(a, b, c, d, x, s, ac)
	a = xpay_md5AddUnsigned(a, xpay_md5AddUnsigned(xpay_md5AddUnsigned(xpay_md5I(b, c, d), x), ac))
	a = xpay_md5RotateLeft(a, s)
	a = xpay_md5AddUnsigned(a, b)
End Sub

Function xpay_md5WordArray(sMessage)
	Dim ml,nw,bp,bc,wc,mb,cb
	Dim wa()
	mb = 512
	cb = 448
	ml = LenB(sMessage)
	nw = (((ml + ((mb - cb) \ 8)) \ (mb \ 8)) + 1) * (mb \ 32)
	ReDim wa(nw - 1)
	bp = 0
	bc = 0
	Do Until bc >= ml
		wc = bc \ 4
		bp = (bc Mod 4) * 8
		wa(wc) = wa(wc) Or xpay_md5LShift(AscB(MidB(sMessage, bc + 1, 1)), bp)
		bc = bc + 1
	Loop
	wc = bc \ 4
	bp = (bc Mod 4) * 8
	wa(wc) = wa(wc) Or xpay_md5LShift(&H80, bp)
	wa(nw - 2) = xpay_md5LShift(ml, 3)
	wa(nw - 1) = xpay_md5RShift(ml, 29)
	xpay_md5WordArray = wa
End Function

Function xpay_md5WordToHex(v)
	Dim b,c
	For c = 0 To 3
		b = xpay_md5RShift(v, c * 8) And xpay_md5lOnBits(8 - 1)
		xpay_md5WordToHex = xpay_md5WordToHex & Right("0" & Hex(b), 2)
	Next
End Function

Function xpay_md5ToAnsi(varstr)
	Dim varchar, code, codearr, j, i
	xpay_md5ToAnsi = ""
	For i=1 To Len(varstr)
		varchar = Mid(varstr,i,1)
		code = Server.UrlEncode(varchar)
		If(code="+") Then code="%20"
		If Len(code) = 1 Then
			xpay_md5ToAnsi = xpay_md5ToAnsi & ChrB(AscB(code))
		Else
			codearr = Split(code,"%")
			For j = 1 to UBound(codearr)
				xpay_md5ToAnsi = xpay_md5ToAnsi & ChrB("&H" & codearr(j))
			Next
		End If
	Next
End Function
Function xpay_md5Todec2bin(n)
	Dim i,r
	If n >= 2 ^ 31 Then n=2 ^ 31
	Do
		If (n And 2 ^ i) = 2 ^ i Then
			r = "1" & r
		Else
			r = "0" & r
		End If
		i = i + 1
	Loop Until 2 ^ i > n
	xpay_md5Todec2bin=r
End Function
Function xpay_md5Tobin2dec(v)
	Dim i
	Dim t
	Dim r
	Dim d
	d = Len(v)
	For i = d To 1 Step -1
		t = Mid(v, i, 1)
		If t = "1" Then r = r + 2 ^ (d - i)
	Next
	xpay_md5Tobin2dec = r
End Function
%>
