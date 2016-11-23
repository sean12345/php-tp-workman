<?php
/**
 * This file is part of workerman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link http://www.workerman.net/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
use Workerman\Worker;


require_once APP_PATH . 'Org/Workerman/Autoloader.php';
require_once __DIR__ . '/ThriftWorker.php';

// echo APP_PATH; exit;

$worker = new ThriftWorker('tcp://0.0.0.0:9090');
$worker->count = 16;
$worker->class = 'HelloWorld';


// 如果不是在根目录启动，则运行runAll方法
if(!defined('GLOBAL_START'))
{
    Worker::runAll();
}
