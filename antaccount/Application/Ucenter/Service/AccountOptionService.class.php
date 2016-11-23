<?php
namespace Ucenter\Service;

use Base\ExceptionHandler;
use Base\BaseService;
use Ucenter\Model\AntNest\CommonModel;

class AccountOptionService extends CommonService{

    Protected $autoCheckFields = false;

    /**
     *  添加新账号
     *
     * @param  int      $accountType
     * @param  string  $parama['account_name']
     * @param  string  $parama['mobile']
     * @param  string  $parama['email']
     * @param  string  $parama['manager_account_id']
     * @param  string  $parama['manager_ip']
     * 
     * @return mix
     */
    public function addAccount($accountType='', $params=array())
    {    
        $data = array(
            'account_name' => $params['account_name'],
            'mobile' => $params['mobile'],
            'pwd' => $params['pwd'],
            'email' => $params['email'],
            'manager_account_id' => $params['manager_account_id'],
            'manager_ip' => $params['manager_ip'],
            'status' => CommonModel::ACCOUNT_STATUS_ACTIVE, // 暂时未使用到待激活状态，新注册用户默认为启用状态
        );
        // $accountObj = D('AntNest\Account', 'Model');
        $accountObj = $this->getModel($accountType, 'account');
        $accountObj->startTrans();
        $validate = array(
            // array('account_type', 'checkAccountType', '5011', 3, 'callback'),
            // array('email', '/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i', '5008', 0),
            // array('mobile', '/^1[34578]\d{9}$/', '5005', 0),
            array('account_name,mobile', '', '5003', 1, 'unique', 3),
            array('mobile', '', '5006', 1, 'unique', 3),
            array('email', '', '5009', 1, 'unique', 3),
            array('sex', 'checkSexType', '5108', 3, 'callback'),
            array('province_id', '/^\d{0,8}$/', '5109', 3),
            array('city_id', '/^\d{0,8}$/', '5110', 3),
            array('nick_name', '/^[\x4E00-\x9FA5\w]{0,16}$/', '5106', 3),
        );
        $accountObj->setProperty('_validate', $validate);
        if (!$accountObj->create($data, 1)) {
            $err = $accountObj->getError();
            ExceptionHandler::make_throw($accountObj->getError());
        }
        $accountID = $accountObj->add();
        if (!$accountID) {
            ExceptionHandler::make_throw('0004');
        }
        $data = array(
            'account_id' => $accountID,
            'action_source' => '', //TODO  具体用途待定
            'opt_type' => CommonModel::OPTION_TYPE_ADD,
            'option' => '添加新用户',
            'remark' => !empty($params['remark']) ? $params['remark'] : '',
            'manager_account_id' => !empty($params['manager_account_id']) ? $params['manager_account_id'] : '',
            'manager_ip' => !empty($params['manager_ip']) ? $params['manager_ip'] : '',
        );
        $resLog = D('AccountOptionLog', 'Service')->accountOptionLog($accountType, $data);
        if (!isset($resLog) || $resLog === false) {
            $accountObj->rollback();
            ExceptionHandler::make_throw('0008');
        }
        $accountObj->commit();
        return $accountID;
    }

    /**
     * 激活账号
     *
     * @param  int      $accountType
     * @param  string  $accountID
     * @param  string  $managerID
     * @param  string  $managerIP
     * 
     * @return mix
     */
    public function activeAccount($accountType='', $accountID='', $managerID='', $managerIP='')
    {
        // $accountObj = D('AntNest\Account', 'Model');
        $accountObj = $this->getModel($accountType, 'account');
        $cond = array(
            'account_id' => $accountID,
        );
        $info= $accountObj->where($cond)->find();
        if (!$info) {
            ExceptionHandler::make_throw('5201');
        }
        $data = array(
            'status' => CommonModel::ACCOUNT_STATUS_ACTIVE
        );
        $accountObj->startTrans();
        $res = $accountObj->where($cond)->save($data);
        if ($res === false) {
            $accountObj->rollback();
            ExceptionHandler::make_throw('0004');
        }
        $data = array(
            'account_id' => $accountID,
            'action_source' => '', //TODO  具体用途待定
            'opt_type' => CommonModel::OPTION_TYPE_ACTIVE,
            'option' => '激活用户',
            'remark' => !empty($params['remark']) ? $params['remark'] : '',
            'manager_account_id' => $managerID,
            'manager_ip' => $managerIP,
        );
        $resLog = D('AccountOptionLog', 'Service')->accountOptionLog($accountType, $data);
        if (!isset($resLog) || $resLog === false) {
            $accountObj->rollback();
            ExceptionHandler::make_throw('0004');
        }
        $accountObj->commit();
        return true;
    }

    /**
     * 禁用账号
     *
     * @param  int      $accountType
     * @param  string  $accountID
     * @param  string  $managerID
     * @param  string  $managerIP
     * 
     * @return mix
     */
    public function inactiveAccount($accountType='', $accountID='', $managerID='', $managerIP='')
    {
        // $accountObj = D('AntNest\Account', 'Model');
        $accountObj = $this->getModel($accountType, 'account');
        $cond = array(
            'account_id' => $accountID,
        );
        $info= $accountObj->where($cond)->find();
        if (!$info) {
            ExceptionHandler::make_throw('5301');
        }
        $data = array(
            'status' => CommonModel::ACCOUNT_STATUS_INACTIVE
        );
        $accountObj->startTrans();
        $res = $accountObj->where($cond)->save($data);
        if ($res === false) {
            $accountObj->rollback();
            ExceptionHandler::make_throw('0004');
        }
        $data = array(
            'account_id' => $accountID,
            'action_source' => '', //TODO 具体用途待定
            'opt_type' => CommonModel::OPTION_TYPE_INACTIVE,
            'option' => '禁用用户',
            'remark' => !empty($params['remark']) ? $params['remark'] : '',
            'manager_account_id' => $managerID,
            'manager_ip' => $managerIP,
        );
        $resLog = D('AccountOptionLog', 'Service')->accountOptionLog($accountType, $data);
        if (!isset($resLog) || $resLog === false) {
            $accountObj->rollback();
            ExceptionHandler::make_throw('0004');
        }
        $accountObj->commit();
        return true;
    }

    /**
     * 销毁账号
     *
     * @param  int      $accountType
     * @param  string  $accountID
     * @param  string  $managerID
     * @param  string  $managerIP
     * 
     * @return mix
     */
    public function cancelAccount($accountType='', $accountID='', $managerID='', $managerIP='')
    {
        // $accountObj = D('AntNest\Account', 'Model');
        $accountObj = $this->getModel($accountType, 'account');
        $cond = array(
            'account_id' => $accountID,
        );
        $info= $accountObj->where($cond)->find();
        if (!$info) {
            ExceptionHandler::make_throw('5301');
        }
        $data = array(
            'status' => CommonModel::ACCOUNT_STATUS_CANCEL
        );
        $accountObj->startTrans();
        $res = $accountObj->where($cond)->save($data);
        if ($res !== false) {
            $accountObj->rollback();
            ExceptionHandler::make_throw('0004');
        }
        $data = array(
            'account_id' => $accountID,
            'action_source' => '', //TODO  具体用途待定
            'opt_type' => CommonModel::OPTION_TYPE_CANCEL,
            'option' => '销毁用户',
            'remark' => !empty($params['remark']) ? $params['remark'] : '',
            'manager_account_id' => $managerID,
            'manager_ip' => $managerIP,
        );
        $resLog = D('AccountOptionLog', 'Service')->accountOptionLog($accountType, $data);
        if (!isset($resLog) || $resLog === false) {
            $accountObj->rollback();
            ExceptionHandler::make_throw('0004');
        }
        $accountObj->commit();
        return true;
    }

    /**
     * 修改账号密码
     *
     * @param  int      $accountType
     * @param  string  $accountID
     * @param  string  $managerID
     * @param  string  $managerIP
     * @param  string  $pwdNew
     * 
     * @return mix
     */
    public function changePassword($accountType='', $accountID='', $managerID='', $managerIP='', $pwdNew='')
    {
        // $accountObj = D('AntNest\Account', 'Model');
        $accountObj = $this->getModel($accountType, 'account');
        $cond = array(
            'account_id' => $accountID,
            // 'pwd' => generatePassword($pwdOld),
        );
        $data = array(
            'pwd' => !empty($pwdNew) ? $pwdNew: md5(C('DEFAULAT_USER_PWD')),
        );
//        $validate = array(
//            array('pwd', '/^([a-zA-Z0-9@*#]{6,22})$/', '5502', 0), // 正则验证密码 [需包含字母数字以及@*#中的一种,长度为6-22位]
//        );
//        $accountObj->setProperty('_validate', $validate);
        if (!$accountObj->create($data, 2)) {
            ExceptionHandler::make_throw($accountObj->getError());
        }
        $res = $accountObj->where($cond)->save();
        if (!$res) {
            ExceptionHandler::make_throw('0004');
        }
        // 记录登录日志
        $data = array(
            'account_id' => $accountID,
            'action_source' => '', //TODO  具体用途待定
            'opt_type' => CommonModel::OPTION_TYPE_RESETPWD,
            'option' => '重置用户密码',
            'remark' => '',
            'manager_account_id' => $managerID,
            'manager_ip' => $managerIP,
        );
        $resLog = D('AccountOptionLog', 'Service')->accountOptionLog($accountType, $data);
        if (!isset($resLog) || $resLog === false) {
            $accountObj->rollback();
            ExceptionHandler::make_throw('0004');
        }
        return true;
    }

    /**
     * 修改账号资料
     *
     * @param  int      $accountType
     * @param  array  $data
     * 
     * @return mix
     */
    public function changeUserInfo($accountType='', $data=array())
    {
        // $profileObj = D('AntNest\AccountProfile', 'Model');
        $profileObj = $this->getModel($accountType, 'account');
        $validate = array(
            array('account_id','require','5101', 1),
            // array('account_id', '', '5102', 1, 'unique', 3),
            // array('sex', 'checkSexType', '5108', 3, 'callback'),

            array('sex', array(1,2), '5120', self::VALUE_VALIDATE, 'in'),
            array('province_id', '/^\d{0,8}$/', '5109', 3),
            array('city_id', '/^\d{0,8}$/', '5110', 3),
            // array('nick_name', '/^[\x4E00-\x9FA5\w]{0,16}$/', '5106', 3),

            array('account_name', 'require', '5112', self::EXISTS_VALIDATE),
            array('account_name' , '', '5113', self::VALUE_VALIDATE, 'unique', 3),

            array('email', 'require', '5114', self::EXISTS_VALIDATE),
            array('email', '', '5116', self::VALUE_VALIDATE, 'unique', 3),
            array('email', '/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i', '5115', self::VALUE_VALIDATE),

            array('mobile', 'require', '5117', self::EXISTS_VALIDATE),
            array('mobile', '', '5119', self::VALUE_VALIDATE, 'unique', 3),
            array('mobile', '/^1[34578]\d{9}$/', '5118', self::EXISTS_VALIDATE),
            array('u_idcard', '/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/', '5121', 3),

        );
        $profileObj->setProperty('_validate', $validate);
        if (!$profileObj->create($data, 2)) {
            ExceptionHandler::make_throw($profileObj->getError());
        }
        $res = $profileObj->save();
        if (!$res) {
            ExceptionHandler::make_throw('0004');
        }
        // 记录登录日志
        $data = array(
            'account_id' => !empty($data['account_id']) ? $data['account_id'] : '',
            'action_source' => '', //TODO  具体用途待定
            'opt_type' => CommonModel::OPTION_TYPE_SETPROFILE,
            'option' => '修改个人账号资料',
            'remark' => '',
            'manager_account_id' => !empty($data['manager_account_id']) ? $data['manager_account_id'] : '',
            'manager_ip' => !empty($data['manager_ip']) ? $data['manager_ip'] : '',
        );
        $resLog = D('AccountOptionLog', 'Service')->accountOptionLog($accountType, $data);
        if (!isset($resLog) || $resLog === false) {
            ExceptionHandler::make_throw('0008');
        }
        return true;
    }

}