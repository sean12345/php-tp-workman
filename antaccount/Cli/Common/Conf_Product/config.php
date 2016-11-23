<?php
return array(
            //'APP_DEBUG'   =>  true,  // 调试模式开关
            'DEFAULT_AJAX_RETURN'   => 'json',

            'LOG_RECORD'                  => true,  // 进行日志记录
            'LOG_RECORD_LEVEL'        => array('EMERG','ALERT','CRIT','ERR'),  // 允许记录的日志级别 'EMERG','ALERT','CRIT','ERR','WARN','NOTIC','INFO','DEBUG','SQL'
            'LOG_TYPE'                       =>  'File', // 日志记录类型 默认为文件方式

            'DEFAULT_APP'                  => '@',
            'URL_ROUTER_ON'            => true, 

            // 'APP_SUB_DOMAIN_DEPLOY'   =>    1, // 开启子域名或者IP配置
            // 'APP_SUB_DOMAIN_RULES'    =>    array(
            //      /* 域名部署配置
            //       *格式1: '子域名或泛域名或IP'=> '模块名[/控制器名]';
            //       *格式2: '子域名或泛域名或IP'=> array('模块名[/控制器名]','var1=a&var2=b&var3=*');
            //       */ 
            //      // 'local.test.antnest.clcw.com.cn' => 'Utest/Index',
            //       // 'local.test.antnest.clcw.com.cn/sms' => 'SMS/Unittest/index',
            //      // 'local.api.antnest.clcw.com.cn' => 'Admin/Admin',
            //      // 'local.api.antnest.clcw.com.cn' => 'Admin/Admin',
            //      // 'local.api.antnest.clcw.com.cn/sms/' => 'SMS/Index'
            // ),

            'DB_TYPE'                   =>      'mysql', // 数据库类型

            'LOAD_EXT_CONFIG' => array(
                                                                'error_code_prefix',
                                                                'config_error_code',
                                                                'sms_template',
                                                                'exception_code',
                                                                'db',
                                                                'redis',
                                                                ),

            'DEFAULT_M_LAYER'           => 'Model', //默认的模型层名称

            'URL_CASE_INSENSITIVE'    =>false,

            'URL_MODEL'                     => 2, //0 (普通模式); 1 (PATHINFO 模式); 2 (REWRITE  模式); 3 (兼容模式)  默认为PATHINFO 模式

);