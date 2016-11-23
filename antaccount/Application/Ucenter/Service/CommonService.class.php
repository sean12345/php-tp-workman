<?php
namespace Ucenter\Service;

use Base\ExceptionHandler;
use Base\BaseService;
// use Ucenter\Model\AntNest\DealerAccountModel;
// use Ucenter\Model\AntNest\DealerAccountActionLogModel;
// use Ucenter\Model\AntNest\DealerAccountOptionLogModel;

class CommonService extends BaseService{

    Protected $autoCheckFields = false;

    /*账号类型*/
    const ACCOUNT_TYPE_WEB = '1';
    const ACCOUNT_TYPE_DEALER = '2';
    const ACCOUNT_TYPE_4S = '3';
    const ACCOUNT_TYPE_EMPLOYEE = '4';
    const ACCOUNT_TYPE_OWNER = '5';
    const ACCOUNT_TYPE_AGENT = '6';

    /*用户类型集合*/
    private $accountTypes =  array(
      'ACCOUNT_TYPE_WEB' => self::ACCOUNT_TYPE_WEB,
      'ACCOUNT_TYPE_DEALER' => self::ACCOUNT_TYPE_DEALER,
      'ACCOUNT_TYPE_4S' => self::ACCOUNT_TYPE_4S,
      'ACCOUNT_TYPE_EMPLOYEE' => self::ACCOUNT_TYPE_EMPLOYEE,
      'ACCOUNT_TYPE_OWNER' => self::ACCOUNT_TYPE_OWNER,
      'ACCOUNT_TYPE_AGENT' => self::ACCOUNT_TYPE_AGENT,
    );

    public function getAccountTypes() {
        return $this->accountTypes;
    }

    /**
     * 根据账号类型获取模型对象
     *
     * @param  string   $accountType [dealer, owner, customer, employee, 4s, agent, bloc]
     * @param  string   $modelName [account, account_action_log, account_option_log]
     *
     * @return mix
     */
    public function getModel($accountType='', $modelName='') {
            $models = array();
            switch ($accountType) {
                case self::ACCOUNT_TYPE_DEALER:
                    $models['account'] = function() {
                        return D('AntNest\DealerAccount', 'Model');
                    };
                    $models['account_action_log'] = function() {
                        return D('AntNest\DealerAccountActionLog', 'Model');
                    };
                    $models['account_option_log'] = function() {
                         return D('AntNest\DealerAccountOptionLog', 'Model');
                    };
                    break;
                case self::ACCOUNT_TYPE_EMPLOYEE:
                    $models['account'] = function() {
                        return D('AntNest\EmployeeAccount', 'Model');
                    };
                    $models['account_action_log'] = function() {
                        return D('AntNest\EmployeeAccountActionLog', 'Model');
                    };
                    $models['account_option_log'] = function() {
                         return D('AntNest\EmployeeAccountOptionLog', 'Model');
                    };
                    break;
                case self::ACCOUNT_TYPE_WEB:
                    $models['account'] = function() {
                        return D('AntNest\ClcwAccount', 'Model');
                    };
                    $models['account_action_log'] = function() {
                        return D('AntNest\ClcwAccountActionLog', 'Model');
                    };
                    $models['account_option_log'] = function() {
                         return D('AntNest\ClcwAccountOptionLog', 'Model');
                    };
                    break;
                default:
                    break;
            }
            return $models[$modelName]();
    }

    /**
     * 判断账号类型是否有效
     *
     * @param int   $accountType
     *
     * @return mix
     */
    protected function checkAccountType($accountType='') {
        $res = true;
        if (!array_search($accountType, $this->accountTypes)) {
            $res = false;
        }
        return $res;
    }

}