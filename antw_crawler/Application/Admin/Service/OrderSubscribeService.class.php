<?php
namespace Admin\Service;

use Base\ExceptionHandler;
use Base\BaseService;
use \Common\Org\PhpRedis;

class OrderSubscribeService extends BaseService {
    private $Redis;
    private $_subOrderTaskListKey = 'ant_list_auction_orderadd';
    
    Protected $autoCheckFields = false;

    public function __construct() {
        $this->Redis = new PhpRedis();
    }

    /**
     * 获取订阅拍单任务量
     *
     * @return mix
     */
    public function getSubOrderTaskCount()
    {
        try {
            $this->Redis->ping();
        } catch (\Exception $e) {
            $this->Redis = new PhpRedis();
        }
        $res = $this->Redis->lLen($this->_subOrderTaskListKey);
        return $res;
    }

    /**
     * 添加订阅拍单任务
     *
     * @param  string  $mobile  短信接收人电话
     * @param  int  $number  短信自定义类型
     * @param  array  $msgTplParams  短信模块参数
     * 
     * @return index
     */
    public function addSubOrderTask($accountID='', $orderID='', $subType='')
    {
        $taskContent = array(
                                       'appkey' => I('server.HTTP_APPKEY'), // 在服务器端用该appkey获取对应的secretkey, 如果获取不到则证明该appkey无效
                                       'account_id' => $accountID,
                                       'order_id' => $orderID,
                                       'sub_type' => $subType,
                                       'request_time' => timeNow(),
                                       );
        $taskContent = json_encode($taskContent);
        $res = $this->Redis->lPush($this->_subOrderTaskListKey, $taskContent);
        return $res;
    }

    /**
     * 处理订阅拍单任务
     *
     * 任务消费者
     *
     * 
     * @return mix
     */
    public function checkoutSubOrderTask()
    {
        $res = false;
        $taskContent = $this->Redis->rPop($this->_subOrderTaskListKey);
        $taskContent = json_decode($taskContent, true);
        if ($taskContent) {
            $res = $this->subOrderDistribute($taskContent);
        }
        return  $res;
    }

    /**
     * 拍单订阅分发
     * 
     * @param  array  $subContent 
     * 
     * @return mix
     */
    private function subOrderDistribute($subContent=array())
    {
            $res = false;
            // TODO 业务处理
            // $res = $obj->msgSend($subContent['account_id'], $subContent['order_id'], $subContent['sub_type']);
            $distributeStatus = $res ? '1' : '0';
            $resLog = $this->saveSubOrderDistributeLog($appkey, $account_id, $order_id, $requestTime, $subContent, $res['result']);
            if (!$resLog) {
                ExceptionHandler::make_throw('0012');
            }
            return $res;
    }


    /**
     * 记录拍单订阅分发日志
     *
     * @param int $appkey
     * @param int $accountID
     * @param int $orderID
     * @param int $requestTime
     * @param array $subContent
     * @param int $distributeStatus
     * 
     * @return boolean
     */
    private function saveSubOrderDistributeLog($appkey='', $accountID='', $orderID='', $requestTime='', $subContent=array(), $distributeStatus='') {
        $paramsLog = array(
            'appkey' => $appkey,
            'account_id' => $accountID,
            'order_id' => $orderID,
            'task_content' => json_encode($subContent),
            'distribute_status' => $distributeStatus,
            'request_time' => $requestTime,
        );
        if($distributeStatus == '1') {
            $paramsLog['remark'] = 'OK';
        } else {
            $paramsLog['remark'] = 'Faild';
        }
        $res = D('Admin/OrderSubscribeLog', 'Service')->saveSubOrderDistributeLog($paramsLog);
        return $res;
    }

}