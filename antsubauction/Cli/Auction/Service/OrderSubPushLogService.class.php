<?php
namespace Auction\Service;

use Base\ExceptionHandler;
use Base\BaseService;

class OrderSubPushLogService extends BaseService {
    Protected $autoCheckFields = false;

    /**
     * 拍单订阅推送日志
     * 
     * @param  array  $params  
     * 
     * @return boolean
     */
    public function saveSubPushLog($params=array())
    {
        $res = array();
        $data = array(
            'app_key' => !empty($params['app_key']) ? $params['app_key'] : '',
            'app_secret' => !empty($params['app_secret']) ? $params['app_secret'] : '',
            'order_id' => !empty($params['order_id']) ? $params['order_id'] : '',
            'notice_info' => !empty($params['notice_info']) ? $params['notice_info'] : '',
            'jpush_id' => !empty($params['jpush_id']) ?  $params['jpush_id'] : '',
            'response_code' => !empty($params['response_code']) ? $params['response_code'] : '',
            'remark' => !empty($params['remark']) ? $params['remark'] : '',
            'request_time' => !empty($params['request_time']) ? $params['request_time'] : '',
            'createtime' => timeNow(),
        );
        $modelObj = D('Auction/AntNest/SubPushLog')->db(10, C('DB_ANT_NEST'), true);
        $res = $modelObj->data($data)->add();
        return $res;
    }

}