```
-- 将数据库调整为支持中文，否则数据库中存入中文字符串会变成问号
ALTER DATABASE xqk_db COLLATE Chinese_PRC_90_CI_AS

-- 表
IF EXISTS (SELECT * FROM sys.objects WHERE name = 'xqk_test') DROP TABLE xqk_test;
CREATE TABLE [xqk_test](
    [id] [int] IDENTITY(1,1) NOT NULL,
	[test_key] [nvarchar](50) NOT NULL,
	[user_name] [nvarchar](22) NULL,
	[user_salt] [nvarchar](50) NULL,
	[password] [nvarchar](33) NULL,
	[nick_name] [nvarchar](44) NULL,
	[sex] [int] NULL,
	[age] [int] NOT NULL DEFAULT 0,
	[balance] [decimal](18, 2) NOT NULL,
	[create_time] [datetime] NULL,
	[contents] [nvarchar](max) NULL,
    CONSTRAINT [PK_xqk_test_id] PRIMARY KEY CLUSTERED ([id] ASC)
);

-- 唯一键
ALTER TABLE [xqk_test] ADD CONSTRAINT [IX_xqk_test_user_key] UNIQUE NONCLUSTERED ([test_key] ASC);

-- 默认值
-- ALTER TABLE [xqk_test] ADD  CONSTRAINT [DF_xqk_test_age]  DEFAULT ((0)) FOR [age]

-- 数据
INSERT INTO [xqk_test] ([test_key], [user_name], [user_salt], [password], [nick_name], [sex], [age], [balance], [create_time], [contents]) VALUES ('64648485.21232f297a57a5a743894a0e4a801fc3', 'admin', 'dcba14f8c8a43118ecb99dd7ba493ea0', '60383678942fb047356f3afa058de5ff', '管理员', 1, 55, 51098.88, '2023-05-17T15:38:44', '管理员拥有无限的权利');
INSERT [xqk_test] ([test_key], [user_name], [user_salt], [password], [nick_name], [sex], [age], [balance], [create_time], [contents]) VALUES ('64648485.b33aed8f3134996703dc39f9a7c95783', 'agent', '93bb7044b3513e30e29b2cbf973ea32c', '186c42b43f7ac5cba3bfa6ae7653803b', '代理商', 1, 44, 4875.23, '2023-05-17 15:38:45', '代理商下游有很多用户');
INSERT [xqk_test] ([test_key], [user_name], [user_salt], [password], [nick_name], [sex], [age], [balance], [create_time], [contents]) VALUES ('64648486.ee11cbb19052e40b07aac0ca060c23ee', 'user', '9b2eea4b45bcdd5c3b342456bdff139d', '8ed11b05caf627ebefabf2aa6409d8bb', '用户', 0, 33, 357.44, '2023-05-17 15:38:46', '普通用户是最小的服务单元');
INSERT [xqk_test] ([test_key], [user_name], [user_salt], [password], [nick_name], [sex], [age], [balance], [create_time], [contents]) VALUES ('64648487.098f6bcd4621d373cade4e832627b4f6', 'test', '8607f985d1a84dc6c670673040dd9a56', 'd4aeff0f0f41e37b61d6f704d8ae3e32', '测试', 0, 22, 29.68, '2023-05-17 15:38:47', '测试账号');
```

```
IF EXISTS (SELECT * FROM sys.objects WHERE name = 'xqk_ip_log') DROP TABLE xqk_ip_log;
CREATE TABLE [xqk_ip_log](
    [id] [int] IDENTITY(1,1) NOT NULL,
	[ip] [nvarchar](22) NULL,
	[create_date] [nvarchar](20) NULL,
	[create_datetime] [nvarchar](20) NULL,
	[create_timestamp] [int] NOT NULL DEFAULT 0,
    CONSTRAINT [PK_xqk_test_id] PRIMARY KEY CLUSTERED ([id] ASC)
);
```
