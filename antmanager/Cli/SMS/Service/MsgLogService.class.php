<?php
namespace SMS\Service;

use Base\ExceptionHandler;
use Base\BaseService;

class MsgLogService extends BaseService{
    Protected $autoCheckFields = false;

    /**
     * 短信操作相关日志
     * 
     * @param  array  $params  
     * 
     * @return boolean
     */
    public function msgSendLog($params=array())
    {
        $res = array();
        $data = array(
            'appkey' => $params['appkey'],
            'mobile' => $params['mobile'],
            'gateway' => $params['gateway'],
            'msg_type' => $params['msg_type'],
            'msg_var' => $params['msg_var'],
            'response_code' => $params['response_code'],
            'remark' => $params['remark'],
            'request_time' => $params['request_time'],
            'createtime' => timeNow(),
        );
        $modelObj = D('AntNest\MsgSendLog', 'Model')->db(0, C('DB_ANT_NEST'), true);
        $res = $modelObj->data($data)->add();
        return $res;
    }

}