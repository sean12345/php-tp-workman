<?php
/**
 * 短信发送任务操作类
 *
 * 短信发送任务按短信类型分为通知类型和验证码类型，两种类型的短信任务存放在不同的任务队列下互补干扰，验证码类型时效性要求更高
 * 应用Redis List模型实现
 * 
 */
namespace SMS\Service;

use Base\ExceptionHandler;
use Base\BaseService;
use SMS\Service\MsgGateWay\Extension\MsgFactory;
use \Common\Org\PhpRedis;

class MsgTaskService extends BaseService{
    private $Redis;
    private $_notifyTaskListKey = 'list_msg_notifytask';
    private $_verifyTaskListKey = 'list_msg_verifytask';

    Protected $autoCheckFields = false;

    public function __construct() {
        $this->Redis = new PhpRedis();
    }
    
    /**
     * 获取短信通知发送任务量
     *
     * @return mix
     */
    public function getNotifyTaskCount()
    {
        try {
            $this->Redis->ping();
        } catch (\Exception $e) {
            $this->Redis = new PhpRedis();
        }
        $res = $this->Redis->lLen($this->_notifyTaskListKey);
        return $res;
    }

    /**
     * 获取短信通知发送任务列表
     *
     * @param int $start
     * @param int $stop
     * 
     * @return mix
     */
    public function getNotifyTaskList($start=0, $stop=NULL)
    {
        if (!$stop) {
            $stop = $this->getNotifyTaskCount();
        }
        $res = $this->Redis->lRange($this->_notifyTaskListKey, $start, $stop);
        return $res;
    }

    /**
     * 处理短信通知任务
     *
     * 任务消费者
     *
     * @param  string  $gateWayName  短信平台名称,(默认取配置项里的第一个)
     * 
     * @return mix
     */
    public function checkoutNotifyTask($gateWayName='')
    {
        $res = false;
        $taskContent = $this->Redis->rPop($this->_notifyTaskListKey);
        $taskContent = json_decode($taskContent, true);
        if ($taskContent) {
            if ($gateWayName) {
                $resSend = $this->msgSend($gateWayName, $taskContent);
            } else {
                $res = $this->autoSend($taskContent);
            }
            if (!$resSend) {
                $res  = $this->autoSend($taskContent);   
            } else {
                $res = true;
            }
        }
        return $res;
    }

    /**
     * 获取短信验证码发送任务量
     *
     * @return mix
     */
    public function getVerifyTaskCount()
    {
        try {
            $this->Redis->ping();
        } catch (\Exception $e) {
            $this->Redis = new PhpRedis();
        }
        $res = $this->Redis->lLen($this->_verifyTaskListKey);
        return $res;
    }

    /**
     * 获取短信验证码发送任务列表
     *
     * @param int $start
     * @param int $stop
     * 
     * @return mix
     */
    public function getVerifyTaskList($start=0, $stop=NULL)
    {
        if (!$stop) {
            $stop = $this->getNotifyTaskCount();
        }
        $res = $this->Redis->lRange($this->_verifyTaskListKey, $start, $stop);
        return $res;
    }

    /**
     * 处理短信验证码任务
     *
     * 任务消费者
     *
     * @param  string  $gateWayName  短信平台名称,(默认取配置项里的第一个)
     * 
     * @return mix
     */
    public function checkoutVerifyTask($currGateWayName='')
    {
        $content = $this->Redis->rPop($this->_verifyTaskListKey);
        $taskContent = json_decode($content, true);
        if ($taskContent) {
            $taskContent['content_params'] = array(
                'code' => $taskContent['ver_code']
            );
            if ($currGateWayName) {
                $resSend = $this->msgSend($currGateWayName, $taskContent);
            } else {
                $res = $this->autoSend($taskContent);
            }
            if (!$resSend) {
                $res  = $this->autoSend($taskContent);   
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
     * @param  array  $msgContent
     * 
     * @return mix
     */
    private function msgSend($gateWayName='', $msgContent=array())
    {
            $obj = MsgFactory::Create($gateWayName);
            $res = $obj->msgSend($msgContent['appkey'], $msgContent['mobile'], $msgContent['number'], $msgContent['request_time'], $msgContent['content_params']);
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
                $resSend = $this->msgSend($gateWayName, $msgContent);
                if ($resSend) {
                    $res = true;
                    break;
                }
            }
            return $res;
    }

}