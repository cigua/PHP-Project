<?php
return array(
	//'配置项'=>'配置值'

	// 默认分组模块
	'DEFAULT_MODULE'=>'Home',
	// 列出所有的分组列表，必须写在 默认分组模块的下面
	'MODULE_ALLOW_LIST'=>array('Home','Admin'),
	// 开启 Smarty 模板引擎
	'TMPL_ENGINE_TYPE'=>'Smarty',
	// 配置 Smarty 标记
	// 'left_delimiter'=>'<{',
	// 'right_delimiter'=>'}>'

	/* 数据库设置 */
	'DB_TYPE'               =>  'mysql',     // 数据库类型
	'DB_HOST'               =>  'localhost', // 服务器地址
	'DB_NAME'               =>  'shop',          // 数据库名
	'DB_USER'               =>  'root',      // 用户名
	'DB_PWD'                =>  'root',          // 密码
	'DB_PORT'               =>  '3306',        // 端口
	'DB_PREFIX'             =>  'sw_',    // 数据库表前缀
	'DB_PARAMS'          	=>  array(), // 数据库连接参数    
	'DB_DEBUG'  			=>  TRUE, // 数据库调试模式 开启后可以记录SQL日志
	'DB_FIELDS_CACHE'       =>  true,        // 启用字段缓存
	'DB_CHARSET'            =>  'utf8',      // 数据库编码默认采用utf8
);