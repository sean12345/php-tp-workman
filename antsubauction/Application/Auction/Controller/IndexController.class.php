<?php
/**
 * 来拍车拍单订阅处理
 *
 * @category API
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
namespace Auction\Controller;

use Base\ExceptionHandler;

class IndexController extends CommonController {

    public function __construct() 
    {
        $this->checkApiToken();
    }

    /**
     * 添加订阅拍单
     * 
     * @param int $_POST['account_id'] 添加人账号ID
     * @param int $_POST['order_id'] 拍单ID
     * @param int $_POST['sub_type'] 订阅类型(1:车商订阅)
     * 
     * @return json
     */
     public function addSubOrder() {
        $accountID = I('post.account_id', '');
        $orderID = I('post.order_id', '');
        $subType = I('post.sub_type', '');
        try {
            if (empty($accountID)) {
                ExceptionHandler::make_throw('0011');
            }
            if (empty($orderID)) {
                ExceptionHandler::make_throw('0013');
            }
            if (empty($subType)) {
                ExceptionHandler::make_throw('0015');
            }
            $rs =  D('OrderSubscribe', 'Service')->addSubOrderTask($accountID, $orderID, $subType);
            if (!$rs) {
                ExceptionHandler::make_throw('0020');   
            }
        } catch (\Exception $e) {
            $this->returnException($e);
        }
        $this->returnResponse(true);
     }

    /**
     * 添加Jpush推送任务
     * 
     * @param int $_POST['mobile'] 接收人手机号
     * @param int $_POST['jpush_id'] jqushID
     * @param int $_POST['jpush_type'] 打开类型(例如 0:打开APP, 1:打开活动, 2:打开拍单详情, 3:打开维修保养详情, 4:打开维修保养查询历史列表)
     * @param int $_POST['jpush_data'] 消息解析参数集合(JSON)
     * @param int $_POST['jpush_content'] 推送内容
     * 
     * @return json
     */
     public function sendJpushMsg() {
        $mobile = I('post.mobile', '');
        $jpushID = I('post.jpush_id', '');
        $jpushType = I('post.jpush_type', '');
        $jpushData = I('post.jpush_data', '');
        $noticeInfo = I('post.jpush_content', '');
        try {
            if (empty($mobile)) {
                ExceptionHandler::make_throw('0022');
            }
            if (empty($jpushID)) {
                ExceptionHandler::make_throw('0021');
            }
            if (empty($noticeInfo)) {
                ExceptionHandler::make_throw('0023');
            }
            $params = array(
                'mobile' => $mobile,
                'jpush_id' => $jpushID,
                'jpush_type' => $jpushType,
                'jpush_data' => $jpushData,
                'notice_info' => $noticeInfo,
            );
            $rs =  D('Jpush', 'Service')->jpushSend($params);
            if (!$rs) {
                ExceptionHandler::make_throw('0024');   
            }
        } catch (\Exception $e) {
            $this->returnException($e);
        }
        $this->returnResponse(true);
     }

}
