<?php
namespace Auction\Service;

use Base\ExceptionHandler;
use Base\BaseService;

class OrderSubLogService extends BaseService {
    Protected $autoCheckFields = false;

    /**
     * 拍单订阅分发日志
     * 
     * @param  array  $params  
     * 
     * @return boolean
     */
    public function saveSubOrderDistributeLog($params=array())
    {
        $res = array();
        $data = array(
            'appkey' => $params['appkey'],
            'account_id' => $params['account_id'],
            'order_id' => $params['order_id'],
            'task_content' => $params['task_content'],
            'distribute_status' => $params['distribute_status'],
            'remark' => $params['remark'],
            'request_time' => $params['request_time'],
            'createtime' => timeNow(),
        );
        $modelObj = D('Auction/AntNest/SubLog', 'Model')->db(10, C('DB_ANT_NEST'), true);
        $res = $modelObj->data($data)->add();
        return $res;
    }

}