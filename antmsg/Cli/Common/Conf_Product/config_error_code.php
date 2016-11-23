<?php
return array(
        'SYS_EXCEPTION_CODE'    => array(
            // 短息资源错误码
            '-1'                   =>      '未知异常',
            '0000'               =>      '成功',
            '0001'               =>      '当前请求资源不存在！',
            
             /*接口请求鉴权*/
            '100010'            =>       '接口请求授权码必填！',
            '100011'            =>       '请求授权参数app_key无效！',
            '100012'            =>       '请求授权参数secret_key无效！',
            '100013'            =>       '接口访问令牌已过期！',
        ),
);