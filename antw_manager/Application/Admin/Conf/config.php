<?php
return array(
    //'配置项'=>'配置值'

            'APP_AUTOLOAD_PATH' => 'Think.Util.,ORG.Util.,@.Base.',

            'LAYOUT_ON' => true,
            'LAYOUT_NAME' => 'Layout/admin_main',

            'DB_TYPE' => 'mysql', // 数据库类型
            'DB_HOST' => '192.168.2.115', // 服务器地址
            'DB_NAME' => 'ant_nest', // 数据库名
            'DB_USER' => 'dbuser', // 用户名
            'DB_PWD' => '123456', // 密码
            'DB_PORT' => '3306', // 端口
            'DB_PREFIX' => 'ant_', // 数据库表前缀
            'DB_CHARSET' => 'utf8', // 数据库编码默认采用utf8

            'LOAD_EXT_CONFIG' => array(
                                                                'db',
                                                                'redis',
                                                                'config_error_code',
                                                                'authorization_console',
                                                                ),

            'TMPL_PARSE_STRING' => array (
                  '__PUBLIC__' => 'http://'.$_SERVER['HTTP_HOST'].'/Application/'. MODULE_NAME .'/Public', // 更改默认的/Public 替换规则
            ),
            
            'REALPATH_ROOT' => $_SERVER['DOCUMENT_ROOT'] . '/',

            'CRAWLER_PATH_ROOT' => $_SERVER['DOCUMENT_ROOT'] . '/../weaver-crawler/',

            'SESSION_AUTO_START' => true, // 是否自动开启Session
            'SESSION_OPTIONS' =>  array(
                                // session 配置数组 支持type name id path expire domain 等参数
                                'type' => 'Db',
                                'expire' => 3600, // 过期时间为3600
            ),
            'SESSION_PREFIX' => 'ant', // session 前缀
            'SESSION_TABLE' => 'ant_session', //必须设置成这样，如果不加前缀就找不到数据表，这个需要注意

            'TMPL_ACTION_ERROR' => MODULE_PATH . 'View/Public/error.html',
);