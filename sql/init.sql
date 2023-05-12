CREATE TABLE `xqk_test`.`xqk_user` ( `id` INT NOT NULL , `user_name` VARCHAR(22) NOT NULL , `password` VARCHAR(33) NOT NULL , `nick_name` VARCHAR(44) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
ALTER TABLE `xqk_user` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT;
INSERT INTO `xqk_test`.`xqk_user` (`id`, `user_name`, `password`, `nick_name`) VALUES (NULL, 'admin', 'admin', '管理员'), (NULL, 'agent', 'agent', '代理'), (NULL, 'user', 'user', '用户'), (NULL, 'test', 'test', '测试'), (NULL, 'demo', 'demo', '演示')
