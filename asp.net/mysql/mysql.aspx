<%@ Page Language="C#" %>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>MYSQL</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<body>
<%
	string databaseConnectionString = "Server=127.0.0.1;Port=3306;DataBase=xqk;User Id=root;Password=123456;";
	MySql.Data.MySqlClient.MySqlConnection mySqlConnection = new MySql.Data.MySqlClient.MySqlConnection(databaseConnectionString);
	try
	{
		if (mySqlConnection.State != System.Data.ConnectionState.Open) { mySqlConnection.Open(); }
		MySql.Data.MySqlClient.MySqlCommand mySqlCommand = new MySql.Data.MySqlClient.MySqlCommand(databaseSql, mySqlConnection);
		mySqlCommand.ExecuteNonQuery();
		ExecuteNonQuery("UPDATE [PayOrder] SET [NotifyStatus]=1 WHERE [OrderNo]='123'");
		Response.Write("SUCCESS");
	}
	catch(System.Exception exception)
	{
		Response.Write(exception.Message);
	}
	finally
	{
		mySqlConnection.Close();
		mySqlConnection.Dispose();
		Response.Write("<hr />finally");
	}
%>
</body>
</html>
