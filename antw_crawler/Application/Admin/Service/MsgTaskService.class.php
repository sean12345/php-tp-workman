<?php
/**
 * 短信发送任务操作类
 *
 * 短信发送任务按短信类型分为通知类型和验证码类型，两种类型的短信任务存放在不同的任务队列下互补干扰，验证码类型时效性要求更高
 * 应用Redis List模型实现
 * 
 */
namespace Admin\Service;

use Base\ExceptionHandler;
use Base\BaseService;
use \Common\Org\PhpRedis;

class MsgTaskService extends CommonService{
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
     * 添加短信通知任务
     *
     * @param  string  $mobile  短信接收人电话
     * @param  int  $number  短信自定义类型
     * @param  array  $msgTplParams  短信模块参数
     * 
     * @return index
     */
    public function addNotifyMsgTask($mobile='', $number='', $msgTplParams=array())
    {
        $taskContent = array(
                                       'appkey' => I('server.HTTP_APPKEY'), // 在服务器端用该appkey获取对应的secretkey, 如果获取不到则证明该appkey无效
                                       'mobile' => $mobile,
                                       'number' => $number,
                                       'content_params' => $msgTplParams,
                                       'request_time' => timeNow(),
                                       );
        $taskContent = json_encode($taskContent);
        $res = $this->Redis->lPush($this->_notifyTaskListKey, $taskContent);
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
     * 添加短信通知任务
     *
     * @param  string  $mobile  短信接收人电话
     * @param  int  $number  短信自定义类型
     * @param  int  $ver_code  短信验证码
     * 
     * @return index
     */
    public function addVerifyMsgTask($mobile='', $number='', $ver_code='')
    {
        $taskContent = array(
                                       'appkey' => I('server.HTTP_APPKEY'), // 在服务器端用该appkey获取对应的secretkey, 如果获取不到则证明该appkey无效
                                       'mobile' => $mobile,
                                       'number' => $number,
                                       'ver_code' => $ver_code,
                                       'request_time' => timeNow(),
                                       );
        $taskContent = json_encode($taskContent);
        $res = $this->Redis->lPush($this->_verifyTaskListKey, $taskContent);
        return $res;
    }

}