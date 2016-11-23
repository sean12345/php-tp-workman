<?php
/**
 * AN服务平台
 * 公共异常码
 *
 * @access  public
 * @category API
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
return array(
            // 短息资源错误码
            '-1'          => '未知异常',
            '0000'      => '成功',
            '0001'      => '当前请求资源不存在！',
            
             /*接口请求鉴权*/
            '100010'    => '接口请求授权码必填！',
            '100011'    => '请求授权参数app_key无效！',
            '100012'    => '请求授权参数secret_key无效！',
            '100013'    => '接口访问令牌已过期！',
);