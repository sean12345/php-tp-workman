<?php
/**
 * ant-weaver服务管理平台
 *
 * 优信拍数据抓取服务管理
 *
 *
 * @category API
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
namespace Admin\Controller;

use Base\ExceptionHandler;
use Base\BaseModel;

class YouxinpaiController extends CommonController {

    public function taskServiceLog() {
        $this->isLogin();

        $file = C('AUCTION_PATH_ROOT') . 'Cli' . DIRECTORY_SEPARATOR . 'Auction' . DIRECTORY_SEPARATOR . 'Data' . DIRECTORY_SEPARATOR . 'SubOrderPushWorker' . DIRECTORY_SEPARATOR .'stdout.log';
        $contentSubOrderPush = fileTail($file, 50);

        $file = C('AUCTION_PATH_ROOT') . 'Cli' . DIRECTORY_SEPARATOR . 'Auction' . DIRECTORY_SEPARATOR . 'Data' . DIRECTORY_SEPARATOR . 'SubOrderWorker' . DIRECTORY_SEPARATOR .'stdout.log';
        $contentSubOrder = fileTail($file, 50);

        $this->assign('content_suborderpush', $contentSubOrderPush);
        $this->assign('content_suborder', $contentSubOrder);
        $this->display('task_service');
    }

    public function monitor(){
        $this->isLogin();
        // 获取各任务队列待处理任务总数
        $orderSubPushTaskObj = D('OrderSubPush', 'Service');
        $subPushTaskCount = $orderSubPushTaskObj->getSubPushTaskCount();
        $subOrderTaskCount = D('OrderSubscribe', 'Service')->getSubOrderTaskCount();
        // 获取任务状态
        $subPushServiceStatus = $orderSubPushTaskObj->getSubPushTaskServiceStatus();
        $this->assign('subpush_task_count', $subPushTaskCount);
        $this->assign('suborder_task_count', $subOrderTaskCount);
        $this->assign('subpush_service_status', $subPushServiceStatus);
        $this->display('monitor');
    }

    public function ajaxSubPushServiceStop() {
        $res = D('OrderSubPush', 'Service')->subPushTaskServiceStop();
        $this->returnResponse($res);
    }

    public function ajaxSubPushServiceStart() {
        $res = D('OrderSubPush', 'Service')->subPushTaskServiceStart();
        $this->returnResponse($res);
    }

}