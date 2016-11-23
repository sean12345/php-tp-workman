<?php
/**
 * 短信服务任务模块基础类
 *
 *
 * @category Controller
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
namespace SMS\Controller;
use Base\BaseController;
class CommonController extends BaseController {
        public function _initialize()
        {
        }

        /**
        * 实时发送短信
        * 
        * @param  string  $mobile  短信接收人电话
        * @param  int  $number  短信自定义类型
        * @param  array  $params  短信模块参数
        * 
        * @return mix
        */
        public function msgSendActual($mobile='', $number='', $params=array())
        {
                $currentGateWay = D('SMS/MsgGateWay', 'Service')->getCurrentGateWayName();
                $res = D('SMS/MsgGateWay', 'Service')->msgSendActual($mobile, $number, $params, $currentGateWay);
                return $res;
        }
}