<?php
/**
 * 服务监控逻辑模型类
 * 
 */
namespace ChannelThrift\Service;

use Base\ExceptionHandler;
use Base\BaseService;
use \Common\Org\PhpRedis;

class MonitorService extends BaseService{
    private $Redis;
    private $serverWarnKey = 'hash_server_warn_sets';
    private $serverWarnPrefix = 'server_warn_';

    public function __construct() {
       $this->Redis = new PhpRedis();
    }

    /**
     * 按IP地址监控服务器是否运行正常
     *
     * @param array $endPoints
     * @return mix
     */
     public function monitorByIP($endPoints=array()) {
         if (!empty($endPoints)) {
             foreach ($endpoints as $endpoint) {
                  $session = new SNMP(SNMP::VERSION_2c, $endpoint, 'boguscommunity');
                  var_dump($session->getError());
                  // do something with the $session->getError() if it exists else, endpoint is up
             }
         }
     }

    /**
    * 按IP:PORT监控服务器相关服务是否正常
    *
    * @param array $serverList
    * @param array $notifyMobiles
    * 
    * @return mix
    */
     public function monitorByPort($serverList=array(), $notifyMobiles=array()) {
        foreach ($serverList as $ser) {
           $addr = 'tcp://' . $ser['ip'];
           $fp = @fsockopen($addr, $ser['port'], $errno, $errstr, 5);
           if (!$fp) {
                foreach ($notifyMobiles as $mobile) {
                    $noteKey = serialize($this->serverWarnPrefix . $ser['ip'] . $ser['port'] . $mobile);
                    // 检测该对象是否已经发送报警信息
                    $rs = $this->Redis->hget($this->serverWarnKey, $noteKey);
                    if (!$rs) {
                        // 发送报警短息
                        $msgContent = array(
                                                    'number' => '50',
                                                    'mobile' => $mobile,
                                                    'appkey' => C('APPKEY'),
                                                    'request_time' => timeNow(),
                                                    'content_params' => array(
                                                                                              'system_name' => $ser['title'],
                                                                                              'level' => '1',
                                                                                              'content' => $ser['desc']
                                                                                          ),
                                                );
                        // $res = D('SMS/MsgGateWay', 'Service')->msgSendActual($mobile, '50', $msgContent);
                        // $res = D('SMS/MsgGateWay', 'Service')->msgSendActual($mobile, '50', $msgContent);
echo PHP_EOL . '----------100--------' . PHP_EOL;
                        $res = R('SMS/Common/msgSendActual', array($msgContent));
echo PHP_EOL . '----------500--------' . PHP_EOL;
                        // 记录已通知对象
                        $this->Redis->hset($this->serverWarnKey, $noteKey, timeNow(), C('SERVER_WARN_EXPIRE'));
                    }
                }
           }
        }
        return true;
     }

}