<?php
return array(
	//数据库配置
	'DB_TYPE' => 'mysql',                //数据库类型
	'DB_HOST' => 'localhost',            //服务器地址
	'DB_NAME' => 'secondhandinfo',       //数据库名
	'DB_USER' => 'root',                 //用户名
	'DB_PWD'  => '',                 //密码
	'DB_PORT' => '3306',                 //端口
	'DB_CHARSET' => 'utf8',              //数据库编码
	//模块
	'MODULE_ALLOW_LIST' => array('Home', 'Admin'),
	'DEFAULT_MODULE'    => 'Home',
	//布局
	'LAYOUT_ON' => true,
	'LAYOUT_NAME' => 'layout',
	//其他配置
	//'URL_MODEL' => 2,                    //URL模式：Rewrite
	'TOKEN_ON' => true,                  //开启表单令牌
	'DEFAULT_FILTER' => 'htmlspecialchars,trim',  //默认过滤函数
	'SHOW_PAGE_TRACE' => true,           //显示调试信息
);
?>