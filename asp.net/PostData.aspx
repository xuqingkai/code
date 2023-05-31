<%@ Page Language="C#"%>
<%
string result = PostData(); 
string filePath = System.Web.HttpContext.Current.Server.MapPath("./InputStream.txt"); 
System.IO.File.AppendAllText(filePath, result + "", System.Text.Encoding.UTF8);
%>
<script runat="server">
    public string PostData(string charset = "UTF-8")
    {
        System.IO.Stream stream = System.Web.HttpContext.Current.Request.InputStream;
        stream.Position = 0;
        byte[] bytes = new byte[stream.Length];
        stream.Read(bytes, 0, bytes.Length);
        string result = System.Text.Encoding.GetEncoding(charset).GetString(bytes);
        return result;
    }
</script>
