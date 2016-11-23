<?php
/**
 * 蚁巢服务API入口文件
 *
 * 蚁巢服务主要针对车来车往相关产品线提供行为服务支持，支持短信服务、用户中心服务、邮件服务、支付服务等
 *
 * @access  public
 * @category API
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */

// 检测PHP环境
if(version_compare(PHP_VERSION, '5.3.0',' <'))  die('require PHP > 5.3.0 !');
header("Content-type:text/html;charset=utf-8;");

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG', True);

define('ROOT_PATH', './');


// 定义应用目录
define('APP_PATH', './Application/');
define('RUNTIME_PATH', APP_PATH . 'Runtime/');

// define('APP_MODE', 'rest');

define('BUILD_DIR_SECURE', false); //关闭目录安全文件的生成
// define('DIR_SECURE_FILENAME', 'index.html'); //目录安全文件

// 引入ThinkPHP入口文件
require './ThinkPHP/ThinkPHP.php';