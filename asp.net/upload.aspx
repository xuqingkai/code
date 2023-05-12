<%@Page Language="C#"%>
<%
Response.Write("name1: "+Request.Form["name1"]+"<br />");
Response.Write("name2: "+Request.Form["name2"]+"<br />");
Response.Write("name2: "+Request.Form["name2[]"]+"<br />");
System.Web.HttpFileCollection files = System.Web.HttpContext.Current.Request.Files;
for (int i = 0; i < files.Count; i++)
{
    string field = files.AllKeys[i];
    System.Web.HttpPostedFile file = files[i];
    Response.Write(field + ": "+file.FileName+"<br />");	
}
%>
