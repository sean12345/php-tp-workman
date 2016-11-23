<?php
namespace SMS\Service;

use Base\ExceptionHandler;
use Base\BaseService;
use SMS\Service\MsgGateWay\Extension\MsgFactory;
use \Common\Org\PhpRedis;

class MsgGateWayService extends BaseService{
    private $Redis;
    private $mob_code_key = 'mob_code_';

    public function __construct() {
        $this->Redis = new PhpRedis();
    }

    Protected $autoCheckFields = false;

    /**
     * 获取当前正在使用的网关
     * 
     * @return mix
     */
    public function getCurrentGateWayName() {
        $res = false;
        $mod = D('SMS/AntNest/MsgGateway', 'Model');
        $res = $mod->scope('gateway_current')->getField('gateway_name');
        return $res;
    }

    /**
     * 实时发送短信
     * 
     * @param  array  $params  短信模块参数
     * @param  string  $gateWayName  短信平台名称,(默认取配置项里的第一个)
     * 
     * @return mix
     */
    public function msgSendActual($params=array(), $gateWayName='')
    {
        $res = false;
        if ($params) {
            if ($gateWayName) {
                $resSend = $this->doMsgSend($gateWayName, $params);
            } else {
                $res = $this->autoSend($params);
            }
            if (!$resSend) {
                $res  = $this->autoSend($params);   
            } else {
                $res = true;
            }
        }
        return $res;
    }

    /**
     * 短信发送
     * 
     * @param  string  $gateWayName
     * @param  array  $taskContent
     * 
     * @return mix
     */
    private function doMsgSend($gateWayName='', $taskContent=array())
    {
            $obj = MsgFactory::Create($gateWayName);
            $res = $obj->msgSend($taskContent['appkey'], $taskContent['mobile'], $taskContent['number'], $taskContent['request_time'], $taskContent['content_params']);
            return $res;
    }

    /**
     * 短信自动遍历网关列表进行发送
     *
     * 只要短信发送成功就退出本次遍历
     *
     * @param  array  $msgContent 短信内容
     * 
     * @return [type] [description]
     */
    private function autoSend($msgContent = '') {
            $res = false;
            $gateWayList = MsgFactory::getMsgGateWayList();
            foreach ($gateWayList as $gateWayName) {
                $resSend = $this->doMsgSend($gateWayName, $msgContent);
                if ($resSend) {
                    $res = true;
                    break;
                }
            }
            return $res;
    }

}