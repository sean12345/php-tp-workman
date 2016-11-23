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
          /*Admin*/
          array('admin/debuger/request', 'Admin/Debuger/apiRequest'),
          array('admin/debuger/:m_from', 'Admin/Debuger/show'),
          array('admin/test/:m_from', 'Admin/Unittest/index', '', array('method'=>'GET')),
          array('admin/doc/:m_from', 'Admin/Static/doc', '', array('method'=>'GET')),
          array('admin/doc', 'Admin/Static/doc?m_from=Admin', '', array('method'=>'GET')),

          // /*Transfer*/
          // // 用户活动类
          // // 'transfer/rsa/getkey'                   => 'Transfer/Rsa/getKey',
          // array('transfer/rsa/getkey', 'Transfer/Rsa/getKey', '', array('method'=>'GET')),

          // /*Ucenter*/
          // // 用户活动类
          // array('ucenter/api/accounts/regist', 'Ucenter/AccountAction/registAccount', '', array('method'=>'POST')),
          // array('ucenter/api/accounts/login', 'Ucenter/AccountAction/accountLogin', '', array('method'=>'POST')),
          // array('ucenter/api/accounts/logout', 'Ucenter/AccountAction/accountLogout', '', array('method'=>'POST')),
          // array('ucenter/api/accounts/retrievepwd', 'Ucenter/AccountAction/retrievePassword', '', array('method'=>'POST')),
          // array('ucenter/api/accounts/changepwd', 'Ucenter/AccountAction/changePassword', '', array('method'=>'POST')),
          // array('ucenter/api/accounts/changeinfo', 'Ucenter/AccountAction/changeInfo', '', array('method'=>'POST')),
          // array('ucenter/api/accounts/info', 'Ucenter/AccountAction/getAccountInfo', '', array('method'=>'GET')),
          // array('ucenter/api/accounts/getpwd', 'Ucenter/AccountAction/getAccountPwd', '', array('method'=>'GET')),
          // array('ucenter/api/accounts/check', 'Ucenter/AccountAction/checkAccount', '', array('method'=>'GET')),

          // // 用户账号管理
          // array('ucenter/api/accounts/add', 'Ucenter/AccountOption/addAccount', '', array('method'=>'POST')),
          // array('ucenter/api/accounts/active', 'Ucenter/AccountOption/activeAccount', '', array('method'=>'POST')),
          // array('ucenter/api/accounts/inactive', 'Ucenter/AccountOption/inactiveAccount', '', array('method'=>'POST')),
          // array('ucenter/api/accounts/cancel', 'Ucenter/AccountOption/cancelAccount', '', array('method'=>'POST')),
          // array('ucenter/api/accounts/resetpwd', 'Ucenter/AccountOption/resetPassword', '', array('method'=>'POST')),
          // array('ucenter/api/accounts/changeuserinfo', 'Ucenter/AccountOption/changeUserInfo', '', array('method'=>'POST')),
          // // 测试
          // array('ucenter/test/:is_fetch', 'Ucenter/Unittest/index', '', array('method'=>'GET')),
          // array('ucenter/test', 'Ucenter/Unittest/index', '', array('method'=>'GET')),
          // // 说明文档
          // array('ucenter/doc/:doc_name', 'Admin/Static/doc?m_from=Ucenter', ' ', array('method'=>'GET')),          
          // array('ucenter/doc', 'Admin/Static/doc?m_from=Ucenter', ' ', array('method'=>'GET')),

          // /*SMS*/
          // array('sms/api/notify', 'SMS/Index/sendNotification', '', array('method'=>'POST')),
          // array('sms/api/codesend', 'SMS/Index/sendVerifyCode', '', array('method'=>'POST')),
          // array('sms/api/verify', 'SMS/Index/verifyCode', '', array('method'=>'POST')),
          // // 测试
          // array('sms/test/:is_fetch', 'SMS/Unittest/index', '', array('method'=>'GET')),
          // array('sms/test', 'SMS/Unittest/index', '', array('method'=>'GET')),
          // // 说明文档
          // array('sms/doc/:doc_name', 'Admin/Static/doc?m_from=SMS', ' ', array('method'=>'GET')),
          // array('sms/doc', 'Admin/Static/doc?m_from=SMS', ' ', array('method'=>'GET')),
          // array('sms/doc/:doc_name', 'Admin/Static/doc', ' ', array('method'=>'GET')),
          // array('sms/test/:m', 'SMS/Unittest/index', ' ', array('method'=>'GET')),

);