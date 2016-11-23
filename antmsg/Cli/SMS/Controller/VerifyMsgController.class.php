<?php
/**
 * 短信验证码服务任务模块
 *
 * @category API
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
namespace SMS\Controller;

use Workerman\Worker;
use Workerman\Lib\Timer;
use GatewayWorker\Register;

class VerifyMsgController extends CommonController {
    /**
     * 短信验证码发送
     *
     * @return mix
     */
    public function msgProcess() {
        import('Org.Workerman.Autoloader', APP_PATH, '.php');

        $worker = new Worker('text://127.0.0.1:10022');

        $worker->name = 'VerifyMsgWorker';

        // 每个进程最多执行请求数
        define('MAX_REQUEST', 20);

        $worker->count = 2;

        $worker->transport = 'tcp';// 使用udp协议，默认TCP

        Worker::$daemonize = true;//以守护进程运行

        // $_filePath = RUNTIME_PATH . MODULE_NAME . DIRECTORY_SEPARATOR . $worker->name . DIRECTORY_SEPARATOR;
        $_filePath = MODULE_PATH . 'Data' . DIRECTORY_SEPARATOR . $worker->name . DIRECTORY_SEPARATOR;

        if (!is_dir($_filePath)) mkdir($_filePath, 0777, true);

        Worker::$pidFile = $_filePath . 'workerman.pid';//方便监控WorkerMan进程状态

        Worker::$stdoutFile = $_filePath . 'stdout.log'; //输出日志, 如echo，var_dump等

        Worker::$logFile = $_filePath . 'workerman.log';//workerman自身相关的日志，包括启动、停止等,不包含任何业务日志

        $worker->onWorkerStart = function($worker) {
            $time_interval = 2;
            $currentGateWay = D('SMS/MsgGateWay', 'Service')->getCurrentGateWayName();
            echo  date('[Y-m-d H:i:s]') . "Worker starting. worker_id: " . getmypid() . ", Current Msg GateWay: {$currentGateWay}." . PHP_EOL;
            Timer::add($time_interval, function($currentGateWay)
            {
                $taskStartCount = $taskCount = D('SMS/MsgTask', 'Service')->getVerifyTaskCount($currentGateWay);                
                while ($taskCount > 0) {
                    try{
                        $msgTaskObj = D('SMS/MsgTask', 'Service');
                        // 领取短信发送任务并处理
                        $res = $msgTaskObj->checkoutVerifyTask($currentGateWay);
                        $taskCount = $msgTaskObj->getVerifyTaskCount();
                        // echo "当前任务总数: ". $taskStartCount . ", ";
                        // echo "剩余任务总数: ". $taskCount . PHP_EOL;
                        if (!$taskCount) break;
                    } catch (\Exception $e) {
                        echo  date('[Y-m-d H:i:s]') . "[Exception] code:" . $e->getCode() . ", msg:" . $e->getMessage() . PHP_EOL;
                    }
                }
            }, array($currentGateWay));
        };

        $worker->onBufferFull = function($connection){
            echo "bufferFull and do not send again" . PHP_EOL;
        };

        $worker->onBufferDrain = function($connection){
            echo "buffer drain and continue send" . PHP_EOL;
        };

        $worker->onWorkerStop = function($worker){
            echo "Worker stopping..." . PHP_EOL;
        };

        $worker->onError = function($connection, $code, $msg){
            echo "error $code $msg" . PHP_EOL;
        };

        // 运行worker
        Worker::runAll();
    }
}