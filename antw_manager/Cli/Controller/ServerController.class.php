<?php
/**
 * 服务运行情况监控模块
 *
 * @category API
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
namespace ChannelThrift\Controller;

use Workerman\Worker;

class ServerController extends CommonController
{

    /**
     * 运行监控服务
     *
     * @return mix
     */
    public function run()
    {
        echo "------------------" . PHP_EOL;
        require_once MODULE_PATH . 'Org/ThriftRpc/start.php';
        echo PHP_EOL . "------------------" . PHP_EOL;
    }


    public function runBail()
    {
        require_once APP_PATH . 'Org/Workerman/Autoloader.php';
        require_once MODULE_PATH . 'Org/ThriftRpc/ThriftWorker.php';

        $worker = new \ThriftWorker('tcp://0.0.0.0:9090');
        $worker->count = 16;
        $worker->class = 'BailService';


        if (!defined('GLOBAL_START')) {
            Worker::runAll();
        }
        
    }

}