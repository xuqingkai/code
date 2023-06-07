<script runat="server">
		/// <summary>
		/// 公钥加密
		/// </summary>
		/// <param name="publicRSA">RSA对象</param>
		/// <param name="content">待加密数据</param>
		/// <returns></returns>
		public static string RSAEncrypt(System.Security.Cryptography.RSACryptoServiceProvider publicRSA, string content, string charset = "UTF-8")
		{
			byte[] byteText = System.Text.Encoding.GetEncoding(charset).GetBytes(content);
			int maxSize = publicRSA.KeySize / 8 - 11;
			System.IO.MemoryStream source = new System.IO.MemoryStream(byteText);
			System.IO.MemoryStream target = new System.IO.MemoryStream();
			byte[] buffer = new byte[maxSize];
			int size = source.Read(buffer, 0, maxSize);
			while (size > 0)
			{
				byte[] temp = new byte[size];
				System.Array.Copy(buffer, 0, temp, 0, size);
				
				byte[] encrypt = publicRSA.Encrypt(temp, false);
				target.Write(encrypt, 0, encrypt.Length);
				size = source.Read(buffer, 0, maxSize);
			}
			return System.Convert.ToBase64String(target.ToArray(), System.Base64FormattingOptions.None);
		}

		/// <summary>
		/// 私钥解密
		/// </summary>
		/// <param name="privateRSA">RSA对象</param>
		/// <param name="content">待解密字符串</param>
		/// <returns></returns>
		public static string RSADecrypt(System.Security.Cryptography.RSACryptoServiceProvider privateRSA, string content, string charset = "UTF-8")
		{
			byte[] byteText = System.Convert.FromBase64String(content);
			int keySize = privateRSA.KeySize / 8;
			System.IO.MemoryStream source = new System.IO.MemoryStream(byteText);
			System.IO.MemoryStream target = new System.IO.MemoryStream();
			byte[] buffer = new byte[keySize];
			int size = source.Read(buffer, 0, keySize);
			while (size > 0)
			{
				byte[] temp = new byte[size];
				System.Array.Copy(buffer, 0, temp, 0, size);
				
				byte[] decrypt = privateRSA.Decrypt(temp, false);
				target.Write(decrypt, 0, decrypt.Length);
				size = source.Read(buffer, 0, keySize);
			}
			return System.Text.Encoding.GetEncoding(charset).GetString(target.ToArray());
		}

		/// <summary>
		/// 私钥签名
		/// </summary>
		/// <param name="privateRSA">RSA对象</param>
		/// <param name="bytes">待签数据</param>
		/// <param name="hashType">哈希摘要模式</param>
		/// <returns></returns>
		public static string RSASign(System.Security.Cryptography.RSACryptoServiceProvider privateRSA, byte[] bytes, string hashType = "SHA1")
		{
			return System.Convert.ToBase64String(privateRSA.SignData(bytes, hashType));
		}

		/// <summary>
		/// 私钥签名
		/// </summary>
		/// <param name="privateRSA">RSA对象</param>
		/// <param name="content">待签数据</param>
		/// <param name="hashType">哈希摘要模式</param>
		/// <returns></returns>
		public static string RSASign(System.Security.Cryptography.RSACryptoServiceProvider privateRSA, string content, string hashType = "SHA1")
		{
			byte[] bytes = System.Text.Encoding.GetEncoding("UTF-8").GetBytes(content);
			return System.Convert.ToBase64String(privateRSA.SignData(bytes, hashType));
		}

		/// <summary>
		/// 公钥验签
		/// </summary>
		/// <param name="rsa">RSA对象</param>
		/// <param name="bytes">待签数据</param>
		/// <param name="signature">签名结果</param>
		/// <param name="hashType">哈希摘要模式</param>
		/// <returns></returns>
		public static bool RSAVerify(System.Security.Cryptography.RSACryptoServiceProvider publicRSA, byte[] bytes, string signature, string hashType = "SHA1")
		{
			return publicRSA.VerifyData(bytes, hashType, System.Convert.FromBase64String(signature));
		}
		
		/// <summary>
		/// 公钥验签
		/// </summary>
		/// <param name="rsa">RSA对象</param>
		/// <param name="content">待签数据</param>
		/// <param name="signature">签名结果</param>
		/// <param name="hashType">哈希摘要模式</param>
		/// <returns></returns>
		public static bool RSAVerify(System.Security.Cryptography.RSACryptoServiceProvider publicRSA, string content, string signature, string hashType = "SHA1")
		{
			byte[] bytes = System.Text.Encoding.GetEncoding("UTF-8").GetBytes(content);
			return publicRSA.VerifyData(bytes, hashType, System.Convert.FromBase64String(signature));
		}
</script>
