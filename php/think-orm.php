<?php
//composer require topthink/think-orm

include_once './vendor/autoload.php'; //导入composer自动加载文件

use think\facade\Db;

// 数据库配置信息设置（全局有效）
Db::setConfig([
    // 默认数据连接标识
    'default'     => 'mysql',
    // 数据库连接信息
    'connections' => [
        'mysql' => [
            // 数据库类型
            'type'     => 'mysql',
            // 主机地址
            'hostname' => '127.0.0.1',
            // 数据库名
            'database' => 'peis',
            // 用户名
            'username' => 'peis',
            //密码
            'password' => 'pscale_pw_X1en7okJGqRdyPUMbAR4vqpF2I2JLKVdjUOB2tpaCmQ',
            //端口
            'hostport' => '3306',
            //参数
            'params'    => [],
            // 数据库编码默认采用utf8
            'charset'  => 'utf8',
            // 数据库表前缀
            'prefix'   => 'xqk_',
            // 数据库调试模式
            'debug'    => true,
        ],
    ],
]);
$one=Db::name('test')->find();
exit(json_encode($one));
