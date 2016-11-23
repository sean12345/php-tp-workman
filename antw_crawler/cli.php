<?php
/**
 * 蚁巢任务服务入口文件
 *
 * 蚁巢任务服务主要包括: 数据抓取、图片处理、邮件推送、短信推送等
 *
 * @access  public
 * @category Service
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */

// 检测PHP环境
if(version_compare(PHP_VERSION, '5.3.0',' <'))  die('require PHP > 5.3.0 !');
header("Content-type:text/html;charset=utf-8;");

/*检测运行环境*/
if(strpos(strtolower(PHP_OS), 'win') === 0)
{
    exit("start.php not support windows, please use start_for_win.bat\n");
}
/*检查扩展: pcntl*/
if(!extension_loaded('pcntl'))
{
    exit("Please install pcntl extension. See http://doc3.workerman.net/install/install.html\n");
}
/*检查扩展: posix*/
if(!extension_loaded('posix'))
{
    exit("Please install posix extension. See http://doc3.workerman.net/install/install.html\n");
}

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG', True);

// 定义应用目录
// define('APP_PATH',  dirname(__FILE__) . '/TaskService/');
define('APP_PATH',  dirname(__FILE__) . '/Cli/');
define('RUNTIME_PATH', APP_PATH . 'Runtime/');

define('APP_MODE', 'cli');
// define('APP_STATUS', 'dev'); // 自动加载该状态对应的配置文件（位于Application/Common/Conf/dev.php） dev|test|production

define('BUILD_DIR_SECURE', false); //关闭目录安全文件的生成
// define('DIR_SECURE_FILENAME', 'index.html'); //目录安全文件

// 引入ThinkPHP入口文件
require dirname(__FILE__) . '/ThinkPHP/ThinkPHP.php';