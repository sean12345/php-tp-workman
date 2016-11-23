<?php
/**
 * 服务运行情况监控模块
 *
 * @category API
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
namespace Monitor\Controller;

class ServerMonController extends CommonController {

    /**
     * 运行监控服务
     *
     * @return mix
     */
    public function run() {

        $serverList = C('MONITOR_SERVERS');
        $mobileList = C('WARN_MOBILES');
        $res = D('Monitor/Monitor', 'Service')->monitorByPort($serverList, $mobileList);
        echo $res;
    }
}