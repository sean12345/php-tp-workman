<?php
/**
 * AN服务平台
 * 动态路由表
 *
 * @access  public
 * @category API
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
return array(
          /*SMS*/
          array('sms/api/notify', 'SMS/Index/sendNotification', '', array('method'=>'POST')),
          array('sms/api/codesend', 'SMS/Index/sendVerifyCode', '', array('method'=>'POST')),
          array('sms/api/verify', 'SMS/Index/verifyCode', '', array('method'=>'POST')),
          // 测试
          array('sms/test/:is_fetch', 'SMS/Unittest/index', '', array('method'=>'GET')),
          array('sms/test', 'SMS/Unittest/index', '', array('method'=>'GET')),
          // 说明文档
          array('sms/doc/:doc_name', 'SMS/Static/doc?m_from=SMS', ' ', array('method'=>'GET')),
          array('sms/doc', 'SMS/Static/doc?m_from=SMS', ' ', array('method'=>'GET')),

);