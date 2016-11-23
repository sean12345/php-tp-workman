<?php
namespace Admin\Service;

use Base\ExceptionHandler;
use Base\BaseService;

class OrderSubscribeLogService extends BaseService {
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
        $modelObj = D('Aums\MsgSendLog', 'Model')->db(0, C('DB_AUMS'), true);
        $res = $modelObj->data($data)->add();
        return $res;
    }

    public function getDetail($logId)
    {
        $res = array();
        if (!empty($logId) && is_numeric($logId)) {
            $res = D('MsgSendLog')->find($logId);
        }
        return $res;
    }

    /**
     * 按时间段查询日志
     * 
     * @param  string $bgnTime [description]
     * @param  [type] $endTime [description]
     * @return [type]          [description]
     */
    public function getLogList($bgnTime='', $endTime='', $pageNum=1, $pageSep=10)
    {
        $res = array();
        $condition = array();
        if ($bgnTime > 0 && $endTime > 0) {
            $condition['createtime'] = array(
                array('EGT', $bgnTime.' 00:00:00'),
                array('ELT', $endTime.' 23:59:59'),
            );
        } elseif ($bgnTime > 0) {
            $condition['createtime'] = array('EGT', $bgnTime.' 00:00:00');
        } elseif ($endTime > 0) {
            $condition['createtime'] = array('ELT', $endTime.' 23:59:59');
        }
        $scope = array(
            'limit'         => $pageSep,
            'where'      => $condition,
            'order'       => 'createtime desc',
        );
        $re = D('MsgSendLog')->scope($scope)->select();
        $count = D('MsgSendLog')->scope($scope)->count();
        $res = array(
            'rows' => $re,
            'count' => $count,
        );
        return $res;
    }

}