<?php
/**
 * 短信通知处理服务任务模块
 *
 * @category API
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
namespace Crawler\Controller;

use Workerman\Worker;
use Workerman\Lib\Timer;
use GatewayWorker\Register;

use PhpSimple\HtmlDomParser;
use \Common\Org\Request;

class YouxinpaiController extends CommonController {

    /**
     * 优信拍车辆品牌和车系数据
     * 
     * @return mix
     */
    public function importBrand() {
        // $res = D('Youxinpai', 'Service')->addCrawlerTask();
        $dataFile = MODULE_PATH . 'Data' . DIRECTORY_SEPARATOR . 'youxinpai_brands.txt';
        $dataBrands = file_get_contents($dataFile, true);
        $dataBrands = json_decode($dataBrands, true);
        foreach ($dataBrands as $masterBrand) {
            $data = array(
                'master_brand_id' => $masterBrand['brandid'],
                'master_brand_letter' => $masterBrand['letter'],
                'master_brand_name' => $masterBrand['brandName'],
            );
            $resMasterBrandAdd = D('Youxinpai', 'Service')->addMasterBrand($data);
            if (!empty($masterBrand['carType'])) {
                foreach ($masterBrand['carType'] as $brand) {
                    $data = array(
                        'brand_id' => $brand['id'],
                        'master_brand_id' => $masterBrand['brandid'],
                        'brand_name' => $brand['name'],
                    );
                    $resBrandAdd = D('Youxinpai', 'Service')->addBrand($data);
                }
            }
        }
        // var_dump($dataBrands[0]);
        return true;
    }

    /**
     * 获取优信拍交易大厅拍卖列表数据
     *
     * 从抓取到列表数据中提取拍单ID和车辆ID，并将该数据写入任务队列
     * 
     * @return mix
     */
    public function getCrawlerTask() {
// $res = D('Youxinpai', 'Service')->addCrawlerTask();

        import('Org.Workerman.Autoloader', APP_PATH, '.php');

        $worker = new Worker('text://127.0.0.1:10052');

        $worker->name = 'Crawler_Youxinpai_Gettask_Worker';

        $worker->count = 1;

        // 每个进程最多执行请求数
        define('MAX_REQUEST', 20);

        $worker->transport = 'tcp';// 使用udp协议，默认TCP

        Worker::$daemonize = true;//以守护进程运行

       // $_filePath = RUNTIME_PATH . MODULE_NAME . DIRECTORY_SEPARATOR . $worker->name . DIRECTORY_SEPARATOR;
       $_filePath = MODULE_PATH . 'Data' . DIRECTORY_SEPARATOR . $worker->name . DIRECTORY_SEPARATOR;

       if (!is_dir($_filePath)) mkdir($_filePath, 0777, true);

        Worker::$pidFile = $_filePath . 'workerman.pid';//方便监控WorkerMan进程状态

        Worker::$stdoutFile = $_filePath . 'stdout.log'; //输出日志, 如echo，var_dump等

        Worker::$logFile = $_filePath . 'workerman.log';//workerman自身相关的日志，包括启动、停止等,不包含任何业务日志

        $worker->onWorkerStart = function($worker){
            echo "Worker start..." . PHP_EOL;
            D('Youxinpai', 'Service')->addCrawlerTask();
            $time_interval = 3600; // 间隔1个小时
            Timer::add($time_interval, function()
            {
                D('Youxinpai', 'Service')->addCrawlerTask();
            });
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

    /**
     *处理抓取任务
     *
     * @return mix
     */
    public function processCrawlerTask() {
// $taskObj = D('Crawler/Youxinpai', 'Service');
// $res = $taskObj->checkoutCrawlerTask();
// exit;

        import('Org.Workerman.Autoloader', APP_PATH, '.php');

        $worker = new Worker('text://127.0.0.1:10051');

        $worker->name = 'Crawler_Youxinpai_process_Worker';

        $worker->count = 2;

        // 每个进程最多执行请求数
        define('MAX_REQUEST', 20);

        $worker->transport = 'tcp';// 使用udp协议，默认TCP

        Worker::$daemonize = true;//以守护进程运行

       // $_filePath = RUNTIME_PATH . MODULE_NAME . DIRECTORY_SEPARATOR . $worker->name . DIRECTORY_SEPARATOR;
       $_filePath = MODULE_PATH . 'Data' . DIRECTORY_SEPARATOR . $worker->name . DIRECTORY_SEPARATOR;

       if (!is_dir($_filePath)) mkdir($_filePath, 0777, true);

        Worker::$pidFile = $_filePath . 'workerman.pid';//方便监控WorkerMan进程状态

        Worker::$stdoutFile = $_filePath . 'stdout.log'; //输出日志, 如echo，var_dump等

        Worker::$logFile = $_filePath . 'workerman.log';//workerman自身相关的日志，包括启动、停止等,不包含任何业务日志

        $worker->onWorkerStart = function($worker){
            echo "Worker start..." . PHP_EOL;
            $time_interval = 2;
            Timer::add($time_interval, function()
            {
                $taskCount = D('Crawler/Youxinpai', 'Service')->getTaskCount();
                while ($taskCount > 0) {
                    try{
                        $taskObj = D('Crawler/Youxinpai', 'Service');
                        // 领取短信通知任务并处理
                        $res = $taskObj->checkoutCrawlerTask();
                        $taskCount = $taskObj->getTaskCount();
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

    /**
     * 获取优信拍交易大厅拍卖列表数据
     *
     * 从抓取到列表数据中提取拍单ID和车辆ID，并将该数据写入任务队列
     * 
     * @return mix
     */
    public function crawlerTradePrice() {

        import('Org.Workerman.Autoloader', APP_PATH, '.php');

        $worker = new Worker('text://127.0.0.1:10053');

        $worker->name = 'Crawler_Youxinpai_crawlerTradePrice_Worker';

        $worker->count = 1;

        // 每个进程最多执行请求数
        define('MAX_REQUEST', 20);

        $worker->transport = 'tcp';// 使用udp协议，默认TCP

        Worker::$daemonize = true;//以守护进程运行

       // $_filePath = RUNTIME_PATH . MODULE_NAME . DIRECTORY_SEPARATOR . $worker->name . DIRECTORY_SEPARATOR;
       $_filePath = MODULE_PATH . 'Data' . DIRECTORY_SEPARATOR . $worker->name . DIRECTORY_SEPARATOR;

       if (!is_dir($_filePath)) mkdir($_filePath, 0777, true);

        Worker::$pidFile = $_filePath . 'workerman.pid';//方便监控WorkerMan进程状态

        Worker::$stdoutFile = $_filePath . 'stdout.log'; //输出日志, 如echo，var_dump等

        Worker::$logFile = $_filePath . 'workerman.log';//workerman自身相关的日志，包括启动、停止等,不包含任何业务日志

        $worker->onWorkerStart = function($worker){
            echo "Worker start..." . PHP_EOL;
            $res = D('Youxinpai', 'Service')->crawlerTradePrice();
            $time_interval = 3600; // 间隔1个小时
            Timer::add($time_interval, function()
            {
                $res = D('Youxinpai', 'Service')->crawlerTradePrice();
            });
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