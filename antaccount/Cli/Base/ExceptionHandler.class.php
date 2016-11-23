<?php
/**
 * 异常处理类
 *
 * @category Exception
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
namespace Base;

use Think\Exception;

class ExceptionHandler extends Exception
{
    /**
    * 抛出异常
    * @param    int $code    异常码
    * @param    string $msg  异常描述信息
    * @return   void
    */
    public static function make_throw($code, $msg='') {
        if (empty($msg)) {
            if (strlen($code) == 4) {
                $moduleName = defined('MODULE_NAME') ? strtoupper(MODULE_NAME) : 'SYS';
                $msgList = C( $moduleName . '_EXCEPTION_CODE');
                $msg = !empty($msgList[$code]) ? $msgList[$code] : '';
                $codePrefixList = C('EXCEPTION_CODE_PREFIX');
                $fullCode = $codePrefixList[$moduleName] . $code;
            } else {
                $moduleName = 'SYS';
                $msgList = C( $moduleName . '_EXCEPTION_CODE');
                $msg = !empty($msgList[$code]) ? $msgList[$code] : '';
                // $codePrefixList = C('EXCEPTION_CODE_PREFIX');
                $fullCode = $code;
            }
        } else {
                $fullCode = $code;
        }
        throw new \Exception($msg, $fullCode);
    }
}