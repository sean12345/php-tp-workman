<?php
/**
 * 蚁巢服务平台
 * 公共配置文件
 *
 * @access  public
 * @category API
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
return array(
            //'APP_DEBUG'   =>  true,  // 调试模式开关
            'DEFAULT_AJAX_RETURN' => 'json',
            
            'LOG_RECORD' => true,  // 进行日志记录
            'LOG_RECORD_LEVEL' => array('EMERG','ALERT','CRIT','ERR'),  // 允许记录的日志级别 'EMERG','ALERT','CRIT','ERR','WARN','NOTIC','INFO','DEBUG','SQL'
            'LOG_TYPE' => 'File', // 日志记录类型 默认为文件方式
            
            'DEFAULT_APP' => '@',
            'URL_ROUTER_ON' => true, 

            'LOAD_EXT_CONFIG' => array(
                                                        'EXCEPTION_CODE_PREFIX'                        => 'error_code_prefix',
                                                        'SYS_EXCEPTION_CODE'                             => 'config_error_code',
                                                        'URL_ROUTE_RULES'                                   => 'router_dynamic',
                                                        'URL_MAP_RULES'                                       => 'router_static',
                                                        'AUTHORIZATION_API_COMMON'               => 'authorization_api_common',
                                                        ),

            'DEFAULT_M_LAYER' => 'Model', // 默认的模型层名称

            'URL_CASE_INSENSITIVE' =>false,
            
            'MODULE_ALLOW_LIST' => array('Ucenter'), // 设置允许访问的模块列表
            'DEFAULT_MODULE' => 'Ucenter',
            'DEFAULT_CONTROLLER' => 'Static',
            'DEFAULT_ACTION' => 'doc',

            'URL_MODEL' =>  2, // 0 (普通模式); 1 (PATHINFO 模式); 2 (REWRITE  模式); 3 (兼容模式)  默认为PATHINFO 模式

            'TMPL_PARSE_STRING' => array (
                  '__PUBLIC__' => 'http://'.$_SERVER['HTTP_HOST'].'/Application/Admin/Public', // 更改默认的/Public 替换规则
            ),
);