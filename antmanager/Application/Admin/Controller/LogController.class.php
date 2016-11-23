<?php
/**
 * ant-nest服务管理平台
 *
 * 日志管理
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

class LogController extends CommonController {

    public function taskService() {
        $this->isLogin();

        $file = C('SMS_PATH_ROOT') . 'Cli' . DIRECTORY_SEPARATOR . 'SMS' . DIRECTORY_SEPARATOR . 'Data' . DIRECTORY_SEPARATOR . 'NotifyMsgWorker' . DIRECTORY_SEPARATOR .'stdout.log';
        $contentNotify = fileTail($file, 50);

        $file = C('SMS_PATH_ROOT') . 'Cli' . DIRECTORY_SEPARATOR . 'SMS' . DIRECTORY_SEPARATOR . 'Data' . DIRECTORY_SEPARATOR . 'VerifyMsgWorker' . DIRECTORY_SEPARATOR .'stdout.log';
        $contentVerify = fileTail($file, 50);

        // $content = file_get_contents($file);
        // $content = explode(PHP_EOL, $content);


        $this->assign('content_notify', $contentNotify);
        $this->assign('content_verify', $contentVerify);
        // $this->assign('content', $s);
        $this->display('task_service');
    }

    public function monitor(){
        $this->isLogin();
        if (IS_POST) {
            $frmNum = I('post.frm_num', '');
            switch ($frmNum) {
                case '1':
                    $gatewayID = I('post.gateway_id', '');
                    D('MsgGateWay', 'Service')->changeCurrentGateway($gatewayID);
                    break;
                default:
                    break;
            }
            $this->redirect('/admin/log/monitor');
        } else {
            // 获取各任务队列待处理任务总数
            $msgTaskObj = D('MsgTask', 'Service');
            $notifyTaskCount = $msgTaskObj->getNotifyTaskCount();
            $verifyTaskCount = $msgTaskObj->getVerifyTaskCount();
            // 按应用appkey统计短信任务处理情况
            $dateBgn = date('Y-m-d H:i:s', strtotime('-1 day'));
            $statisticByApp = D('MsgLog', 'Service')->getStatisticByApp();
            $statisticByApp24 = D('MsgLog', 'Service')->getStatisticByApp($dateBgn);
            // 按短信网关统计短信任务处理情况
            $statisticByGateway24 = D('MsgLog', 'Service')->getStatisticByGateway($dateBgn);
            $statisticByGateway = D('MsgLog', 'Service')->getStatisticByGateway();
            // 获取短信网关列表
            $smsGatewayList = D('MsgGateWay', 'Service')->getGatewayList();
            // 获取任务状态
            $serviceStatus = D('MsgGateWay', 'Service')->getMsgTaskServiceStatus();
            $this->assign('notify_task_count', $notifyTaskCount);
            $this->assign('verify_task_count', $verifyTaskCount);
            $this->assign('statistic_by_app', $statisticByApp);
            $this->assign('statistic_by_app_24', $statisticByApp24);
            $this->assign('statistic_by_gateway', $statisticByGateway);
            $this->assign('statistic_by_gateway_24', $statisticByGateway24);
            $this->assign('gateway_list', $smsGatewayList);
            $this->assign('service_status', $serviceStatus);
            $this->display('monitor');
        }
        return true;
    }

    public function ajaxChangeCurrentGateway() {
        $gatewayID = I('post.gateway_id', '');
        $res = D('MsgGateWay', 'Service')->changeCurrentGateway($gatewayID);
        $this->returnResponse($res);
    }

    public function ajaxMsgServiceStop() {
        $res = D('MsgGateWay', 'Service')->msgTaskServiceStop();
        $this->returnResponse($res);
    }

    public function ajaxMsgServiceStart() {
        $res = D('MsgGateWay', 'Service')->msgTaskServiceStart();
        $this->returnResponse($res);
    }

}