<?php
namespace Ucenter\Service;

use Base\ExceptionHandler;
use Base\BaseService;

class AccountActionLogService extends CommonService{

    Protected $autoCheckFields = false;

    /**
     * 账号活动相关日志
     *
     * @param  int      $accountType
     * @param  array  $params  
     * 
     * @return mix
     */
    public function accountActionLog($accountType, $params=array())
    {
        $data = array(
            'account_id' => !empty($params['account_name']) ? $params['account_name'] : '',
            'action_source' => !empty($params['action_source']) ? $params['action_source'] : '',
            'action_type' => !empty($params['action_type']) ? $params['action_type'] : '',
            'account_id' => !empty($params['account_id']) ? $params['account_id'] : '',
            'option' => !empty($params['option']) ? $params['option'] : '',
            'login_ip' => !empty($params['login_ip']) ? $params['login_ip'] : '',
            'remark' => !empty($params['remark']) ? $params['remark'] : '',
        );
        $logObj = $this->getModel($accountType, 'account_action_log');
        if (!$logObj->create($data, 1)) {
            ExceptionHandler::make_throw('0008', $logObj->getError());
        }
        $res = $logObj->add();
        return $res;
    }

    public function getDetail($logId)
    {
        $res = array();
        if (!empty($logId) && is_numeric($logId)) {
            $res = D('AntNest\AccountActionLog', 'Model')->find($logId);
        }
        return $res;
    }

    /**
     * 按时间段查询日志
     *
     * @param  int      $accountType
     * @param  string $bgnTime [description]
     * @param  [type] $endTime [description]
     * @return [type]          [description]
     */
    public function getLogList($accountType='', $bgnTime='', $endTime='', $pageNum=1, $pageSep=10)
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
        // $logObj = D('AntNest\AccountActionLog', 'Model');
        $logObj = $this->getModel($accountType, 'account_action_log');
        $re = $logObj->scope($scope)->select();
        $count = $logObj->scope($scope)->count();
        $res = array(
            'rows' => $re,
            'count' => $count,
        );
        return $res;
    }

}