<?php
namespace Auction\Service;

use Base\ExceptionHandler;
use Base\BaseService;
use \Common\Org\PhpRedis;

class OrderSubPushService extends BaseService {
    private $Redis;
    private $_subPushTaskListKey = 'ant_list_auction_subpush';

    Protected $autoCheckFields = false;

    public function __construct() {
        $this->Redis = new PhpRedis();
    }

    /**
     * 获取订阅拍单推送任务量
     *
     * @return mix
     */
    public function getSubPushTaskCount()
    {
        try {
            $this->Redis->ping();
        } catch (\Exception $e) {
            $this->Redis = new PhpRedis();
        }
        $res = $this->Redis->lLen($this->_subPushTaskListKey);
        return $res;
    }

    /**
     * 添加订阅拍单推送任务
     *
     * @param  int  $orderID  拍单ID
     * @param  int  $jpushID  jpushID
     * 
     * @return index
     */
    public function addSubPushTask($orderID='', $jpushID='')
    {
        $taskContent = array(
                                       'order_id' => $orderID,
                                       'jpush_id' => $jpushID,
                                       'request_time' => timeNow(),
                                       );
        $taskContent = json_encode($taskContent);
        $res = $this->Redis->lPush($this->_subPushTaskListKey, $taskContent);
        return $res;
    }

    /**
     * 批量添加订阅拍单推送任务
     *
     * @param  array  $oprTaskContent  原始任务内容
     * @param  array $params 订阅推送任务集合
     * 
     * @return index
     */
    public function addMultSubPushTask($oprTaskContent = array(), $params = array())
    {
        if (!empty($params['uid'])) {
            $data = array_unique($params['uid']);
            foreach ($data as $uid) {
                $deviceInfo = D('Auction/AppDevices', 'Service')->getDeviceInfo($uid, 2); // 2:车商
                if (!$deviceInfo) {
                    ExceptionHandler::make_throw('0023');
                }
                $taskContent = array(
                    'order_id' => $params['order_id'],
                    'jpush_id' => $deviceInfo['dev_jpush_id'],
                    'request_time' => timeNow(),
                );
                $taskContent = json_encode($taskContent);
                $resAddPushTask = $this->Redis->lPush($this->_subPushTaskListKey, $taskContent);
                $distributeStatus = $resAddPushTask ? '1' : '0';
                // 记录日志
                $paramsLog = array(
                    'appkey' => $oprTaskContent['appkey'],
                    'account_id' => $uid,
                    'order_id' => $params['order_id'],
                    'task_content' => json_encode($oprTaskContent),
                    'distribute_status' => $distributeStatus,
                    'request_time' => $oprTaskContent['request_time'],
                );
                if ($distributeStatus == '1') {
                    $paramsLog['remark'] = 'OK';
                } else {
                    $paramsLog['remark'] = 'Faild';
                }
                $resLog = D('Auction/OrderSubLog', 'Service')->saveSubOrderDistributeLog($paramsLog);
                if (!$resLog) {
                    ExceptionHandler::make_throw('0024');
                }
            }
        }
        return true;
    }

    /**
     * 处理订阅拍单推送任务
     *
     * 任务消费者
     *
     * 
     * @return mix
     */
    public function checkoutSubPushTask()
    {
            $res = false;
            $taskContent = $this->Redis->rPop($this->_subPushTaskListKey);
            $taskContent = json_decode($taskContent, true);
            if ($taskContent) {
                $resPush = $this->subOrderPush($taskContent);
            }
            $res = $resPush ? true : false;
            return $res;
    }

    /**
     * 拍单订阅推送处理
     *
     * @param array $params
     * 
     * @return mix
     */
    protected function subOrderPush($params=array()) {
        $res = array();
        $appKey = C('JPUSH_LAIPAICHE_APPKEY');
        $masterSecret = C('JPUSH_LAIPAICHE_SECRET');
        $registrationID = !empty($params['jpush_id']) ? $params['jpush_id'] : '';
        $orderID = !empty($params['order_id']) ? $params['order_id'] : '';
        $orderInfo = D('Auction/Order', 'Service')->getOrderInfo($orderID);
        if (!$orderInfo) {
            ExceptionHandler::make_throw('0021');
        }
        $carTitle = D('Auction/Cars', 'Service')->getCarTitle($orderInfo['car_id']);
        if (!$orderInfo) {
            ExceptionHandler::make_throw('0022');
        }
        import('Org.JPush.Autoloader', APP_PATH, '.php');
        $client = new \JPush\Client($appKey, $masterSecret);
        $noticeInfo = "【订阅】{$carTitle}，拍单编号：{$orderInfo['order_no']}，已新鲜上拍，敬请关注！";
        $contentData = array(
            'type' => '2',
            'data' => json_encode(array('order_id' => $orderID)),
        );
        try {
            $resPush = $client->push()
                ->setPlatform(array('ios', 'android'))
                ->addRegistrationId($registrationID)
                ->iosNotification($noticeInfo, array(
                    'extras' => $contentData,
                ))
                ->androidNotification($noticeInfo, array(
                    'title' => '来拍车',
                    'build_id' => 2,
                    'extras' => $contentData,
                ))
                ->options(array(
                    'sendno' => 1000015, // 推送序号
                    'time_to_live' => 86400, // 离线消息保留时长(秒) 默认 86400 （1 天），最长 10 天
                    'apns_production' => true, // APNs是否生产环境
                    // 'big_push_duration' => 100 // 定速推送时长(分钟), 不建议打开
                ))
                ->send();
        } catch (\JPush\Exceptions\APIConnectionException $e) {
            $resPush = array(
                    'code' => $e->getCode(),
                    'msg' => $e->getMessage(),
            );
        } catch (\JPush\Exceptions\APIRequestException $e) {
            $resPush = array(
                    'code' => $e->getCode(),
                    'msg' => $e->getMessage(),
            );
        }
        // 记录推送日志
        $pushLog = array(
            'app_key' => $appKey,
            'app_secret' => $masterSecret,
            'order_id' => $orderID,
            'notice_info' => $noticeInfo,
            'jpush_id' => $registrationID,
            'response_code' => (isset($resPush['http_code']) && $resPush['http_code'] == '200') ? '200' : (!empty($resPush['code']) ? $resPush['code'] : ''),
            'remark' => (isset($resPush['http_code']) && $resPush['http_code'] == '200') ? 'OK' : (!empty($resPush['msg']) ? $resPush['msg'] : ''),
            'request_time' => !empty($params['request_time']) ? $params['request_time'] : ''
        );
        $res = D('OrderSubPushLog', 'Service')->saveSubPushLog($pushLog);
        return $res;
    }

}