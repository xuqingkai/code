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
    string fileExt = System.IO.Path.GetExtension(file.FileName).ToLower() + "";
    string filePath = System.DateTime.Now.ToString("yyyyMMddHHmmss") + "_" + i + "_" + field + fileExt;
	file.SaveAs(System.Web.HttpContext.Current.Server.MapPath(filePath));
}
%>
