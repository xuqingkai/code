-- xqk_user
CREATE TABLE IF NOT EXISTS `xqk_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(50) NOT NULL,
  `user_name` varchar(22) NOT NULL,
  `user_salt` varchar(50) NOT NULL,
  `password` varchar(33) NOT NULL,
  `nick_name` varchar(44) NOT NULL,
  `sex` int(11) NOT NULL,
  `age` int(11) NOT NULL DEFAULT '0',
  `balance` decimal(10,2) NOT NULL,
  `create_datetime` datetime NOT NULL,
  `contents` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1;

-- 数据
INSERT INTO `xqk_user` (`user_id`, `user_name`, `user_salt`, `password`, `nick_name`, `sex`, `age`, `balance`, `create_datetime`, `contents`) VALUES
('64648485.21232f297a57a5a743894a0e4a801fc3', 'admin', 'dcba14f8c8a43118ecb99dd7ba493ea0', '60383678942fb047356f3afa058de5ff', '管理员', 1, 55, '51098.88', '2023-05-17 15:38:44', '管理员拥有无限的权利'),
('64648485.b33aed8f3134996703dc39f9a7c95783', 'agent', '93bb7044b3513e30e29b2cbf973ea32c', '186c42b43f7ac5cba3bfa6ae7653803b', '代理商', 1, 44, '4875.23', '2023-05-17 15:38:45', '代理商下游有很多用户'),
('64648486.ee11cbb19052e40b07aac0ca060c23ee', 'user', '9b2eea4b45bcdd5c3b342456bdff139d', '8ed11b05caf627ebefabf2aa6409d8bb', '用户', 0, 33, '357.44', '2023-05-17 15:38:46', '普通用户是最小的服务单元'),
('64648487.098f6bcd4621d373cade4e832627b4f6', 'test', '8607f985d1a84dc6c670673040dd9a56', 'd4aeff0f0f41e37b61d6f704d8ae3e32', '测试', 0, 22, '29.68', '2023-05-17 15:38:47', '测试账号');

-- xqk_ip_log
CREATE TABLE IF NOT EXISTS `xqk_ip_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
	`ip` varchar(40) NOT NULL,
	`address` varchar(50) NOT NULL,
	`create_date` varchar(10) NOT NULL,
	`create_datetime` varchar(20) NOT NULL,
	`create_timestamp` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1;

INSERT INTO `xqk_ip_log` (`ip`, `address`, `create_date`, `create_datetime`, `create_timestamp`) VALUES ('127.0.0.1', '本地', '1970-01-01', '1970-01-01 08:00:01', 1);

