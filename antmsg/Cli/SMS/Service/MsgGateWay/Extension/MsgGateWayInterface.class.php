<?php
namespace SMS\Service\MsgGateWay\Extension;

use \Common\Exception\ExceptionHandler;

interface MsgGateWayInterface {
    /**
     * 短信通知发送
     * 
     * @param  string  $appkey  appkey应用授权编号
     * @param  string  $to  短信接收人电话
     * @param  int  $type  短信自定义类型
     * @param  int  $requestTime  请求时间
     * @param  array  $params  短信模块参数
     * 
     * @return json
     */
    public function msgSend($appkey, $to, $type, $requestTime, $params);

}