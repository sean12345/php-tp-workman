<?php
namespace Ucenter\Service;

use Base\ExceptionHandler;
use Base\BaseService;

class AccountOptionLogService extends CommonService{

    Protected $autoCheckFields = false;

    /**
     * 账号管理相关日志
     *
     * @param  int      $accountType
     * @param  array  $params  
     * 
     * @return boolean
     */
    public function accountOptionLog($accountType='', $params=array())
    {
        $data = array(
            'account_id' => $params['account_id'],
            'action_source' => $params['action_source'],
            'types' => $params['types'],
            'account_id' => $params['account_id'],
            'option' => $params['option'],
            'remark' => $params['remark'],
            'manager_account_id' => $params['manager_account_id'],
            'manager_ip' => $params['manager_ip'],
        );
        // $logObj = D('AntNest\AccountOptionLog', 'Model');
        $logObj = $this->getModel($accountType, 'account_option_log');
        if (!$logObj->create($data, 1)) {
            ExceptionHandler::make_throw('0007', $logObj->getError());
        }
        $res = $logObj->add();
        return $res;
    }
    /**
     * 获取详情
     * 
     * @param  int      $accountType
     * @param  int      $logId
     * 
     * @return mix
     */
    public function getDetail($accountType='', $logId='')
    {
        $res = array();
        if (!empty($logId) && is_numeric($logId)) {            
            $res = $this->getModel($accountType, 'account_option_log')->find($logId);
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
        $logObj = $this->getModel($accountType, 'account_option_log');
        $re = $logObj->scope($scope)->select();
        $count = $logObj->scope($scope)->count();
        $res = array(
            'rows' => $re,
            'count' => $count,
        );
        return $res;
    }

}