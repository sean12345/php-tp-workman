<?php
namespace Auction\Service;

use Base\ExceptionHandler;
use Base\BaseService;
use \Common\Org\PhpRedis;

class OrderSubService extends BaseService {
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
    public function getSubTaskCount()
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
     * 处理订阅拍单任务
     *
     * 任务消费者
     *
     *
     * @return mix
     */
    public function checkoutSubTask()
    {
        $res = false;
        $taskContent = $this->Redis->rPop($this->_subOrderTaskListKey);
        $taskContent = json_decode($taskContent, true);
        if ($taskContent) {
            $resPush = $this->subOrderDistribute($taskContent);
        }
        $res = $resPush ? true : false;
        return  $res;
    }

    /**
     * 拍单订阅分发
     *
     * 类型(1品牌,2车系,3注册地,4所在地,5年限,6排放)
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
                    $pushTasks = array();
                    foreach ($subscribes as $val){
                        if (isset($val[2]) && isset($val[3]) && isset($val[4]) && isset($val[5]) && isset($val[6])){
                            $subOrderData[] = array(
                                'sid' => $val[2]['sid'],
                                'uid' => $val[2]['uid'],
                                'order_id' => $subContent['order_id'],
                            );
//                            $pushTasks[] = array(
//                                'uid' => $val[2]['uid'],
//                                'order_id' => $subContent['order_id'],
//                            );
                            $pushTasks['uid'][] = $val[2]['uid'];
                            $pushTasks['order_id'] = $subContent['order_id'];
                            // $deviceInfo = D('Auction/CarDealerDevice', 'Service')->getDeviceInfo($val[2]['uid']);
                            // if (!$deviceInfo) {
                            //     ExceptionHandler::make_throw('0023');
                            // }
                            // $resTaskAdd = D('Auction/OrderSubPush', 'Service')->addSubPushTask($subContent['order_id'], $deviceInfo['jpush_id']);
                            // $distributeStatus = $resTaskAdd ? '1' : '0';
                            // // 记录日志
                            // $paramsLog = array(
                            //     'appkey' => $subContent['appkey'],
                            //     'account_id' => $subContent['account_id'],
                            //     'order_id' => $subContent['order_id'],
                            //     'task_content' => json_encode($subContent),
                            //     'distribute_status' => $distributeStatus,
                            //     'request_time' => $subContent['request_time'],
                            // );
                            // if($distributeStatus == '1') {
                            //     $paramsLog['remark'] = 'OK';
                            // } else {
                            //     $paramsLog['remark'] = 'Faild';
                            // }
                            // $resLog = D('Auction/OrderSubLog', 'Service')->saveSubOrderDistributeLog($paramsLog);
                            // if (!$resLog) {
                            //     ExceptionHandler::make_throw('0024');
                            // }
                        }
                    }
                    if ($subOrderData){
                        $resPushTask = D('Auction/OrderSubPush', 'Service')->addMultSubPushTask($subContent, $pushTasks);
                        $res = D('Auction/SubscribeOrder', 'Service')->addSubscribeOrder($subOrderData);                   
                    }
                }
            }
        }
        return $res;
    }

}
