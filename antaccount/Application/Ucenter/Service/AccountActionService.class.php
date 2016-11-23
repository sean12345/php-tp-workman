<?php
namespace Ucenter\Service;

use Base\ExceptionHandler;
use Base\BaseService;

use Ucenter\Model\AntNest\CommonModel;

class AccountActionService extends CommonService{

    Protected $autoCheckFields = false;

    /**
     * 获取账号信息
     * 
     * @param  string  $accountType
     * @param  int  $accountID
     * 
     * @return mix
     */
    public function getAccountInfo($accountType, $accountID)
    {
        $condition = array(
            'account_id'=>$accountID
        );
        $accountObj = $this->getModel($accountType, 'account');
        $info = $accountObj->field('account_id,account_name,pwd,status,email,mobile,nick_name,real_name,u_idcard,account_avatar,sex,province_id,city_id,address,las_login_time,createtime,updatetime')
                                         ->where($condition)
                                         ->find();
        // if (!$info) {
        //     ExceptionHandler::make_throw('1102');
        // }
        return $info;
    }

    /**
     * 批量获取账号信息
     *
     * @param  string  $accountType
     * @param  array  $accountID
     *
     * @return mix
     */
    public function getBatchAccountInfo($accountType, $accountID, $accountName, $page, $pageSize)
    {
        if (!empty($accountID)) {
            $condition = array(
                'account_id' => array('in', $accountID)
            );
        } else {
            $condition = array(
                'account_name' => array('like', "%{$accountName}%"),
            );
        }

        $accountObj = $this->getModel($accountType, 'account');

        if (empty($pageSize)) {
            $info = $accountObj->where($condition)
                ->getField('account_id,account_id,account_name,pwd,status,email,mobile,nick_name,real_name,u_idcard,account_avatar,sex,province_id,city_id,address,las_login_time,createtime,updatetime');
        } else {

            $count = $accountObj->where($condition)->count();

            $page = empty($page) ? 1 : $page;
            $firstRow = $pageSize * ($page - 1);
            $totalPage = ceil($count / $pageSize);
            if (!empty($totalPage) && $page > $totalPage) {
                $page = $totalPage;
            }

            $info = $accountObj->where($condition)->limit($firstRow . ',' . $pageSize)
                ->getField('account_id,account_id,account_name,pwd,status,email,mobile,nick_name,real_name,u_idcard,account_avatar,sex,province_id,city_id,address,las_login_time,createtime,updatetime');

        }
        if (!$info) {
            ExceptionHandler::make_throw('1102');
        }
        $result = array(
            'total' => isset($count) ? $count : count($info),
            'page_now' => isset($page) ? $page : 1,
            'page_total' => isset($totalPage) ? $totalPage : 1,
            'list' => $info
        );
        return $result;
    }

    /**
     * 按手机号获取账号信息
     * 
     * @param  string  $accountType
     * @param  string  $mobile
     * 
     * @return mix
     */
    public function getAccountInfoByMobile($accountType, $mobile)
    {
        $condition = array(
            'mobile'=>$mobile
        );
        $accountObj = $this->getModel($accountType, 'account');
        $info = $accountObj->field('account_id,account_name,email,mobile,nick_name,real_name,u_idcard,account_avatar,sex,province_id,city_id,address,las_login_time,createtime,updatetime')
                                         ->where($condition)
                                         ->find();
        // if (!$info) {
        //     ExceptionHandler::make_throw('1104');
        // }
        return $info;
    }

    /**
     * 按账号名称获取账号信息
     * 
     * @param  string  $accountType
     * @param  string  $accountName
     * 
     * @return mix
     */
    public function getAccountInfoByAccountName($accountType, $accountName)
    {
        $res = array();
        $condition = array(
            'account_name'=>$accountName
        );
        $accountObj = $this->getModel($accountType, 'account');
        $res = $accountObj->field('account_id,account_name,email,mobile,nick_name,real_name,u_idcard,account_avatar,sex,province_id,city_id,address,las_login_time,createtime,updatetime')
                                         ->where($condition)
                                         ->find();

        // if (!$info) {
        //     ExceptionHandler::make_throw('1103');
        // }
        return $res;
    }

    /**
     * 获取账号密码 通过手机号或账号名
     * 
     * @param  string  $accountType
     * @param  string  $userName
     * 
     * @return mix
     */
    public function getAccountPwd($accountType, $userName)
    {
        if (!$this->checkAccountType($accountType)) {
            ExceptionHandler::make_throw('0707');
        }
        $accountObj = $this->getModel($accountType, 'account');
        $cond = array();
        if (preg_match("/^1[34578]\d{9}$/", $userName)) {
            $cond['mobile'] = $userName;
        } else {
            $cond['account_name'] = $userName;
        }
        $pwd = $accountObj->where($cond)->field('account_id,account_name,mobile,pwd')->find();
        if (!$pwd) {
            ExceptionHandler::make_throw('1103');
        }
        return $pwd;
    }

    /**
     * 注册新账号
     * 
     * @param  int      $accountType
     * @param  array  $params
     * @param  string  $parama['account_name']
     * @param  string  $parama['account_type']
     * @param  string  $parama['pwd']
     * @param  string  $parama['mobile']
     * 
     * @return mix
     */
    public function registAccount($accountType='', $params=array())
    {
        $data = array(
            'account_name' => !empty($params['account_name']) ? $params['account_name'] : '',
            'mobile' => !empty($params['mobile']) ? $params['mobile'] : '',
            'email' => !empty($params['email']) ? $params['email'] : '',
            'pwd' => !empty($params['pwd']) ? $params['pwd'] : '',
            'status' => CommonModel::ACCOUNT_STATUS_ACTIVE, // (暂时未使用到待激活状态，新注册用户默认为启用状态)
        );
        $accountObj = $this->getModel($accountType, 'account');
        $validate = array(
            array('account_name', '', '0103', self::VALUE_VALIDATE, 'unique', 3),
            array('email', '', '0109', self::VALUE_VALIDATE, 'unique', 3),
            array('email', '/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i', '0108', self::VALUE_VALIDATE),
            array('mobile', '', '0106', self::VALUE_VALIDATE, 'unique', 3),
            array('mobile', '/^1[34578]\d{9}$/', '0105', self::EXISTS_VALIDATE),
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
            'action_type' => CommonModel::ACTION_TYPE_REGIST,
            'option' => '新用户注册',
            'remark' => !empty($params['remark']) ? $params['remark'] : '',
            'login_ip' => !empty($params['login_ip']) ? $params['login_ip'] : '',
        );
        $resLog = D('AccountActionLog', 'Service')->accountActionLog($accountType, $data);
        if (!isset($resLog) || $resLog === false) {
            ExceptionHandler::make_throw('0008');
        }
        return $accountID;
    }

    /**
     * 账号登录
     *
     * @param  string  $accountType
     * @param  string  $userName
     * @param  string  $pwd
     * 
     * @return mix
     */
    public function accountLogin($accountType='', $userName='', $pwd='')
    {
        $cond = array(
            'pwd' => $pwd
        );
        switch ($accountType) {
            case parent::ACCOUNT_TYPE_WEB: // 官网用户: 注册时手机号必填，并以手机号作为登录名
                if (!preg_match("/^1[34578]\d{9}$/", $userName)) {
                    ExceptionHandler::make_throw('0204');
                }
                $cond['mobile'] = $userName;
                break;
            case parent::ACCOUNT_TYPE_DEALER: // 车商: 注册时账号名、手机号必填，邮箱选填
                if (is_numeric($userName)) {
                    $cond['mobile'] = $userName;
                } else {
                    $cond['account_name'] = $userName;
                }
                break;
            case parent::ACCOUNT_TYPE_4S: // 4S店: 注册时账号名、手机号必填，邮箱不填
            case parent::ACCOUNT_TYPE_EMPLOYEE: // 员工: 注册时账号名、手机号必填，邮箱不填
                $cond['account_name'] = $userName;
                break;
            default:
                ExceptionHandler::make_throw('0208');
                break;
        }
        $accountObj = $this->getModel($accountType, 'account');
        $info = $accountObj->field('*')->where($cond)->find();
        $sql = $accountObj->getLastSql();
        if (empty($info['account_id'])) {
            ExceptionHandler::make_throw('0211');
        }
        switch ($info['status']) {
            case CommonModel::ACCOUNT_STATUS_PENDING:
                ExceptionHandler::make_throw('0005');
                break;
            case CommonModel::ACCOUNT_STATUS_INACTIVE:
                ExceptionHandler::make_throw('0006');
                break;
            case CommonModel::ACCOUNT_STATUS_CANCEL:
                ExceptionHandler::make_throw('0007');
                break;
            default:
                break;
        }
        // 记录最后登录时间
        $resLoginTime = $this->changeLastLoginTime($accountType, $info['account_id']);
        // 记录登录日志
        $data = array(
            'account_id' => $info['account_id'],
            'action_source' => '', //TODO  具体用途待定
            'action_type' => CommonModel::ACTION_TYPE_LOGIN,
            'option' => '用户登录',
            'remark' => !empty($params['remark']) ? $params['remark'] : '',
            'login_ip' => !empty($params['login_ip']) ? $params['login_ip'] : '',
        );
        $resLog = D('AccountActionLog', 'Service')->accountActionLog($accountType, $data);
        if (!isset($resLog) || $resLog === false || $resLoginTime === false) {
            ExceptionHandler::make_throw('0008');
        }
        $res = array(
            'info' => $info,
        );
        return $res;
    }

    /**
     * 账号退出
     *
     * @param  string  $accountType
     * @param  string  $accountID
     * 
     * @return mix
     */
    public function accountLogout($accountType='', $accountID='')
    {

        $res = true;  // TODO 具体操作内容待定
        // 记录登录日志
        $data = array(
            'account_id' => $accountID,
            'action_source' => '', //TODO  具体用途待定
            'action_type' => CommonModel::ACTION_TYPE_LOGOUT,
            'option' => '用户退出',
            'remark' => !empty($params['remark']) ? $params['remark'] : '',
            'login_ip' => !empty($params['login_ip']) ? $params['login_ip'] : '',
        );
        $resLog = D('AccountActionLog', 'Service')->accountActionLog($accountType, $data);
        if (!isset($resLog) || $resLog === false) {
            ExceptionHandler::make_throw('0008');
        }
        return $res;
    }

    /**
     * 重置账号密码
     *
     * 用户找回密码时，根据手机号和账号类型重新设置账号密码
     * 
     * 配合手机号验证码校验
     *
     * @param  int       $accountType
     * @param  string  $mobile
     * @param  string  $pwdNew
     * 
     * @return mix
     */
    public function resetPassword($accountType='', $mobile='', $pwdNew='')
    {
        if (!$this->checkAccountType($accountType)) {
            ExceptionHandler::make_throw('0707');
        }
        $accountObj = $this->getModel($accountType, 'account');
        $cond = array(
            'mobile' => $mobile
        );
        $info = $accountObj->where($cond)->find();
        if (!$info) {
            ExceptionHandler::make_throw('0702');   
        }
        if ($info['pwd'] == $pwdNew) {
            ExceptionHandler::make_throw('0708');    
        }
        $data = array(
            'pwd' => $pwdNew,
        );
        $res = $accountObj->where($cond)->save($data);
        if (!$res) {
            ExceptionHandler::make_throw('0004');
        }
        // 记录登录日志
        $data = array(
            'account_id' => $info['account_id'],
            'action_source' => '', //TODO  具体用途待定
            'action_type' => CommonModel::ACTION_TYPE_RETRIEVEPWD,
            'option' => '找回密码',
            'remark' => '',
            'login_ip' => '',
        );
        $resLog = D('AccountActionLog', 'Service')->accountActionLog($accountType, $data);
        if (!isset($resLog) || $resLog === false) {
            ExceptionHandler::make_throw('0008');
        }
        return true;
    }

    /**
     * 修改账号密码
     * 
     * @param  int       $accountType
     * @param  string  $accountID
     * @param  string  $pwdOld
     * @param  string  $pwdNew
     * 
     * @return mix
     */
    public function changePassword($accountType='', $accountID='', $pwdOld='', $pwdNew='')
    {
        if (!$this->checkAccountType($accountType)) {
            ExceptionHandler::make_throw('0707');
        }
        $accountObj = $this->getModel($accountType, 'account');
        $cond = array(
            'account_id' => $accountID,
        );
        $pwdNow = $accountObj->where($cond)->getField('pwd');
        if (!$pwdNow) {
            ExceptionHandler::make_throw('0802');
        } elseif ($pwdNow !== $pwdOld) {
            ExceptionHandler::make_throw('0804');
        }
        $data = array(
            'pwd' => $pwdNew,
        );
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
            'action_type' => CommonModel::ACTION_TYPE_CHANGEPWD,
            'option' => '修改密码',
            'remark' => '',
            'login_ip' => '',
        );
        $resLog = D('AccountActionLog', 'Service')->accountActionLog($accountType, $data);
        if (!isset($resLog) || $resLog === false) {
            ExceptionHandler::make_throw('0008');
        }
        return true;
    }

    /**
     * 修改账号资料
     *
     * @param  int       $accountType
     * @param  array  $data
     * 
     * @return mix
     */
    public function changeInfo($accountType='', $data=array())
    {
        if (!$this->checkAccountType($accountType)) {
            ExceptionHandler::make_throw('0707');
        }
        $profileObj = $this->getModel($accountType, 'account');
        if (empty($data['account_id'])) {
            ExceptionHandler::make_throw('0901');
        }
        if (!$profileObj->isAaccountExist($data['account_id'])) {
            ExceptionHandler::make_throw('0902');
        }
        $validate = array(
            array('account_id', 'require', '0901', self::MUST_VALIDATE),

            array('account_name', 'require', '0911', self::EXISTS_VALIDATE),
            array('account_name' , '', '0913', self::VALUE_VALIDATE, 'unique', 3),

            array('email', 'require', '0917', self::EXISTS_VALIDATE),
            array('email', '', '0919', self::VALUE_VALIDATE, 'unique', 3),
            array('email', '/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i', '0918', self::VALUE_VALIDATE),

            array('mobile', 'require', '0914', self::EXISTS_VALIDATE),
            array('mobile', '', '0916', self::VALUE_VALIDATE, 'unique', 3),
            array('mobile', '/^1[34578]\d{9}$/', '0915', self::EXISTS_VALIDATE),

            array('sex', array(1,2), '0907', self::VALUE_VALIDATE, 'in'),
            array('province_id', '/^\d{0,8}$/', '0908', 3),
            array('city_id', '/^\d{0,8}$/', '0909', 3),
            // array('nick_name', '/^[\x4E00-\x9FA5\w]{0,16}$/', '0905', 3),
            // array('u_idcard', '/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/', '0920', 3),
        );
        $profileObj->setProperty('_validate', $validate);
        if (!$profileObj->create($data, 2)) {
            $err = $profileObj->getError();
            ExceptionHandler::make_throw($profileObj->getError());
        }
        $res = $profileObj->save();
        if ($res === false) {
            ExceptionHandler::make_throw('0004');
        }
        // 记录登录日志
        $data = array(
            'account_id' => !empty($data['account_id']) ? $data['account_id'] : '',
            'action_source' => '', //TODO  具体用途待定
            'action_type' => CommonModel::ACTION_TYPE_SETPROFILE,
            'option' => '修改个人账号资料',
            'remark' => '',
            'login_ip' => '',
        );
        $resLog = D('AccountActionLog', 'Service')->accountActionLog($accountType, $data);
        if (!isset($resLog) || $resLog === false) {
            ExceptionHandler::make_throw('0008');
        }
        return true;
    }

    /**
     * 按用户ID更新用户最后登录时间
     *
     * @param int    $userID
     * 
     * @return mix
     */
    private function changeLastLoginTime($accountType, $userID='')
    {
        $res = false;
        $profileObj = $this->getModel($accountType, 'account');
        $data = array(
                                'account_id' => $userID,
                                'las_login_time' => timeNow(),
                            );
        if (!$profileObj->create($data, 2)) {
            $err = $profileObj->getError();
            ExceptionHandler::make_throw($profileObj->getError());
        }
        $res = $profileObj->save();
        if ($res === false) {
            ExceptionHandler::make_throw('0004');
        }
        return $res;
    }

}