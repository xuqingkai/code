<%@ Page Language="C#"%>
<%
System.Xml.XmlNode xml = ParseXml("<xml><name>test</name>></xml>");
Response.Write(xml["name"].InnerText);
%>
<script runat="server">
public System.Xml.XmlNode ParseXml(string strXml, string root = null)
{
    if(string.IsNullOrEmpty(root)){
        root = strXml.Trim().Substring(strXml.LastIndexOf("/") + 1);
        root = root.Substring(0, strXml.IndexOf(">")-1);
    }
    System.Xml.XmlDocument xmlDocument = new System.Xml.XmlDocument();
    System.Xml.XmlNode xml = null;
    try
    {
        xmlDocument.LoadXml(strXml.TrimEnd().ToString().EndsWith("</" + root + ">") ? strXml.ToString() : "<" + root + ">" + strXml + "</" + root + ">");
        xml = xmlDocument[root];
    }
    catch(System.Exception exception){
        //exception.Message;
    }
    return xml;
}
</script>
