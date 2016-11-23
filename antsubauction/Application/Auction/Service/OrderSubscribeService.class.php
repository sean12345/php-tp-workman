<?php
namespace Auction\Service;

use Base\ExceptionHandler;
use Base\BaseService;
use \Common\Org\PhpRedis;

class OrderSubscribeService extends BaseService{
    Protected $autoCheckFields = false;
    private $Redis;
    private $_subOrderTaskListKey = 'ant_list_auction_orderadd';

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
     * 获取订阅拍单任务列表
     *
     * @param int $start
     * @param int $stop
     * 
     * @return mix
     */
    public function getSubOrderTaskList($start=0, $stop=NULL)
    {
        if (!$stop) {
            $stop = $this->getNotifyTaskCount();
        }
        $res = $this->Redis->lRange($this->_subOrderTaskListKey, $start, $stop);
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
        $taskContent = array(
            'appkey' => 'AK2016.API.1001',
            'account_id' => '100',
            'order_id' => '1429',
            'sub_type' => '1',
            'request_time' => '2016-09-26 14:42:05'
        );

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
        $orderInfo = D('Auction/Order', 'Service')->getOrderInfo($subContent['order_id']);
        if (isset($orderInfo['car_id'])){
            $carInfo = D('Auction/Cars', 'Service')->getCarsInfo($orderInfo['car_id']);
            if ($carInfo){
                // 类型(1品牌,2车系,3注册地,4所在地,5年限,6排放)

//                $carInfo['series_id'] = 1089;
//                $carInfo['plate_prefix'] = 3;
//                $carInfo['plate_suffix'] = 'D000324';
//                $carInfo['emission'] = 5;
//                $carInfo['first_reg_date'] = '2015-1-1';
//                $carInfo['location_area'] = 120000;

                dump($carInfo['series_id']);
                dump($carInfo['plate_prefix']);
                dump($carInfo['plate_suffix']);
                dump($carInfo['emission']);
                dump($carInfo['first_reg_date']);
                dump($carInfo['location_area']);

                $subscribes = array();

//                $subBrand = D('Auction/SubscribeKey', 'Service')->getSubscribeList(1, $carInfo['mbrand_id']);
//                if ($subBrand){
//                    foreach ($subBrand as $val){
//                        $subscribes[$val['uid'] . $val['sid']][$val['key_type']] = $val;
//                    }
//                }

                $subSeries = D('Auction/SubscribeKey', 'Service')->getSubscribeList(2, $carInfo['series_id']);
                if ($subSeries){
                    foreach ($subSeries as $val){
                        $subscribes[$val['uid'] . $val['sid']][$val['key_type']] = $val;
                    }
                }

                $subRegCity = D('Auction/SubscribeKey', 'Service')->getSubscribeList(3, array($carInfo['plate_prefix'], $carInfo['plate_suffix']));
                if ($subRegCity){
                    foreach ($subRegCity as $val){
                        $subscribes[$val['uid'] . $val['sid']][$val['key_type']] = $val;
                    }
                }

                $subCity = D('Auction/SubscribeKey', 'Service')->getSubscribeList(4, $carInfo['location_area']);
                if ($subCity){
                    foreach ($subCity as $val){
                        $subscribes[$val['uid'] . $val['sid']][$val['key_type']] = $val;
                    }
                }


                $subSeries = D('Auction/SubscribeKey', 'Service')->getSubscribeList(5, $carInfo['first_reg_date']);
                if ($subSeries){
                    foreach ($subSeries as $val){
                        $subscribes[$val['uid'] . $val['sid']][$val['key_type']] = $val;
                    }
                }

                $subEmission = D('Auction/SubscribeKey', 'Service')->getSubscribeList(6, $carInfo['emission']);
                if ($subEmission){
                    foreach ($subEmission as $val){
                        $subscribes[$val['uid'] . $val['sid']][$val['key_type']] = $val;
                    }
                }

                $subOrderData = array();
                if ($subscribes){
                    foreach ($subscribes as $val){
                        if (isset($val[2]) && isset($val[3]) && isset($val[4]) && isset($val[5]) && isset($val[6])){
                            $subOrderData[] = array(
                                'sid' => $val[2]['sid'],
                                'uid' => $val[2]['uid'],
                                'order_id' => $subContent['order_id'],
                            );
                        }
                    }

                    if ($subOrderData){
                        $res = D('Auction/SubscribeOrder', 'Service')->addSubscribeOrder($subOrderData);
                    }
                }
            }
        }

        die;
        $distributeStatus = $res ? '1' : '0';
        $resLog = $this->saveSubOrderDistributeLog($appkey, $account_id, $order_id, $requestTime, $subContent, $distributeStatus);
        if (!$resLog) {
            ExceptionHandler::make_throw('0012');
        }
        return $res;
    }

}