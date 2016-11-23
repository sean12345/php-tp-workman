<?php
/**
 * AN服务平台
 * 静态路由表
 * 
 * @access  public
 * @category API
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
return array(            
          'admin'                                      => 'Admin/Static/doc',
          'admin/main'                             => 'Admin/Admin/index',
          'admin/log/taskservice'             => 'Admin/Log/taskService',
          'admin/log/monitor'                   => 'Admin/Log/monitor',
          'admin/login'                              => 'Admin/Admin/login',
          'admin/logout'                              => 'Admin/Admin/logout',
          
          // 'sms/pub'               => 'Admin/Static/pub',

          /*Transfer*/
          // 用户活动类
          // 'transfer/rsa/getkey'                   => 'Transfer/Rsa/getKey',
          // 说明文档
          // 'transfer/doc'                   => 'Admin/Static/doc?m_from=Transfer',
);