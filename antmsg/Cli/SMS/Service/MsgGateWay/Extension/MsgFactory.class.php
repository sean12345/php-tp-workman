<?php
/**
 * 第三方短信平台接入工厂类
 * 
 */
namespace SMS\Service\MsgGateWay\Extension;

use Base\ExceptionHandler;

class MsgFactory {
    /**
     * 实例化短信平台操作对象
     * 
     * @param  string  $gateWayName 第三方短信平台名称
     * 
     * @return obj
     */
    public static function Create($gateWayName='')
    {
        $gateWayList = array_keys(C('SMS_API'));

        if (empty($gateWayName) || !in_array(strtoupper($gateWayName), $gateWayList)) {
            $gateWayName = !empty($gateWayList[0]) ? $gateWayList[0] : ''; // 在客户端未选择平台的情况下，默认用配置项里排在第一位的短信通道
            if (empty($gateWayName)) {
                ExceptionHandler::make_throw('0004');
            }
        }

        $namespace = getPreNameSpace(__NAMESPACE__);
        $className = $namespace . '\\' . ucfirst(strtolower($gateWayName));
        $obj = new $className();
        $interface = __NAMESPACE__ . '\\MsgGateWayInterface';
        if(!$obj instanceof $interface) {
            ExceptionHandler::make_throw('0001');
        }
        return $obj;
    }

    /**
     * 获取短信网关集合
     * 
     * @return mix
     */
    public static function getMsgGateWayList()
    {
        $res = array();
        if ($res = array_keys(C('SMS_API'))) {
            $unk = array_search('COMMON', $res);
            unset($res[$unk]);
        }
        return $res;
    }

}