<?php
namespace Auction\Service;

use Base\ExceptionHandler;
use Base\BaseService;

class JpushLogService extends BaseService {
    Protected $autoCheckFields = false;

    /**
     * 拍单订阅推送日志
     * 
     * @param  array  $params  
     * 
     * @return boolean
     */
    public function saveJpushLog($params=array())
    {
        $res = array();
        $data = array(
            'app_key' => !empty($params['app_key']) ? $params['app_key'] : '',
            'app_secret' => !empty($params['app_secret']) ? $params['app_secret'] : '',
            'mobile' => !empty($params['mobile']) ? $params['mobile'] : '',
            'notice_info' => !empty($params['notice_info']) ? $params['notice_info'] : '',
            'jpush_id' => !empty($params['jpush_id']) ?  $params['jpush_id'] : '',
            'response_code' => !empty($params['response_code']) ? $params['response_code'] : '',
            'remark' => !empty($params['remark']) ? $params['remark'] : '',
            'request_time' => !empty($params['request_time']) ? $params['request_time'] : '',
            'createtime' => timeNow(),
        );
        $res = D('Auction/AntNest/JpushSendLog')->data($data)->add();
        return $res;
    }

}