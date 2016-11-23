<?php
/**
 * 管理用户账号
 * 用户中心账号服务
 *
 * 提供账号添加、 启用、解禁、销毁、账号信息查询等功能
 *
 * @category API
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
namespace Ucenter\Controller;

use Base\ExceptionHandler;
use Ucenter\Service\CommonService;
use Common\Org\Request;
use Common\Org\RequestComm;
use Common\Org\Xcrypt;

class AccountOptionController extends CommonController {

    public function _initialize() {
        $this->checkApiToken();
    }

    /**
     * 添加新账号
     *
     * @param  string  $param['account_name']
     * @param  string  $param['email']
     * @param  string  $param['mobile']
     * @param  string  $param['account_type']
     * @param  string  $param['manager_account_id']
     * @param  string  $param['manager_ip']
     *
     * @return json
     */
     public function addAccount() {
        $pwd = I('post.pwd', md5(C('DEFAULAT_USER_PWD')));
        $params = array(
            'account_name' => I('post.account_name', ''),
            'pwd' => $pwd,
            'mobile' => I('post.mobile', ''),
            'email' => I('post.email', ''),
            'manager_account_id' => I('post.manager_account_id', ''),
            'manager_ip' => I('post.manager_ip', ''),
        );
        $accountType = I('post.account_type', '');
        try {
            if (empty($accountType)) {
                ExceptionHandler::make_throw('5010');
            }
            if (empty($params['manager_account_id'])) {
                ExceptionHandler::make_throw('0001');
            }
            if (empty($params['manager_ip'])) {
                ExceptionHandler::make_throw('0002');
            }
            // 注册时账号名、手机号、邮箱不能同时为空
            if (empty($params['account_name']) && empty($params['mobile']) && empty($params['email'])) {
                ExceptionHandler::make_throw('5015');   
            }

            if (empty($params['account_name'])) {
                $params['account_name'] = generateAccountName();
            }

            if (empty($params['mobile'])) {
                $params['mobile'] = generateMobile();
            }

            if (empty($params['email'])) {
                $params['email'] = generateEmail();
            }

            // switch ($accountType) {
            //     case CommonService::ACCOUNT_TYPE_WEB: // 官网用户: 注册时手机号必填，并以手机号作为登录名
            //         if (empty($params['mobile'])) {
            //             ExceptionHandler::make_throw('5004');
            //         }
            //         break;
            //     case CommonService::ACCOUNT_TYPE_DEALER: // 车商: 注册时账号名、手机号必填，邮箱选填
            //     case CommonService::ACCOUNT_TYPE_4S: // 4S店: 注册时账号名、手机号必填，邮箱不填
            //     case CommonService::ACCOUNT_TYPE_EMPLOYEE: // 员工: 注册时账号名、手机号必填，邮箱不填
            //         if (empty($params['account_name'])) {
            //             ExceptionHandler::make_throw('5001');
            //         }
            //         if (empty($params['mobile'])) {
            //             ExceptionHandler::make_throw('5004');
            //         }
            //         break;            
            //     default:
            //         ExceptionHandler::make_throw('5011');
            //         break;
            // }
            $accountID =  D('AccountOption', 'Service')->addAccount($accountType, $params);
        } catch (\Exception $e) {
            $this->returnException($e);
        }
        if ($accountID) {
            // $res = array ('account_id' => $accountID, 'pwd' => $pwd);
            $res = D('AccountAction', 'Service')->getAccountInfo($accountType, $accountID);
        } else {
            $res = false;
        }
        $this->returnResponse($res);
     }

    /**
     * 启用账号
     *
     * @param  string  $param['account_type']
     * @param  string  $param['account_id']
     * @param  string  $param['manager_account_id']
     * @param  string  $param['manager_ip']
     *
     * @return json
     */
     public function activeAccount() {
        $accountType = I('post.account_type', '');
        $accountID = I('post.account_id', '');
        $managerID = I('post.manager_account_id', '');
        $managerIP = I('post.manager_ip', '');
        try {
            if (empty($accountID)) {
                ExceptionHandler::make_throw('5201');
            }
            if (empty($managerID)) {
                ExceptionHandler::make_throw('0001');
            }
            if (empty($managerIP)) {
                ExceptionHandler::make_throw('0002');
            }
            $res =  D('AccountOption', 'Service')->activeAccount($accountType, $accountID, $managerID, $managerIP);
        } catch (\Exception $e) {
            $this->returnException($e);
        }
        $this->returnResponse($res);
     }

    /**
     * 禁用账号
     *
     * @param  string  $param['account_type']
     * @param  string  $param['account_id']
     * @param  string  $param['manager_account_id']
     * @param  string  $param['manager_ip']
     *
     * @return json
     */
     public function inactiveAccount() {
        $accountType = I('post.account_type', '');
        $accountID = I('post.account_id', '');
        $managerID = I('post.manager_account_id', '');
        $managerIP = I('post.manager_ip', '');
        try {
            if (empty($accountID)) {
                ExceptionHandler::make_throw('5301');
            }
            if (empty($managerID)) {
                ExceptionHandler::make_throw('0001');
            }
            if (empty($managerIP)) {
                ExceptionHandler::make_throw('0002');
            }
            $res =  D('AccountOption', 'Service')->inactiveAccount($accountType, $accountID, $managerID, $managerIP);
            // 调用来拍车踢人操作API
            $requestObj = new RequestComm();
            $apiUrl = C('LAIPAICHE_KICK_USER');
            $isPost =  1;
            $timeNow = time();
            $params = array(
                'uid' => $accountID,
                'systemtime' => $timeNow,
                'token' => md5($accountID . $timeNow),
            );
            $headers = array(
                "content-type: application/x-www-form-urlencoded; charset=UTF-8",
            );
            $resKick = $requestObj->juhecurl($apiUrl, $headers,  $params, $isPost);            
        } catch (\Exception $e) {
            $this->returnException($e);
        }
        $this->returnResponse($res);
     }

    /**
     * 销毁账号
     *
     * @param  string  $param['account_type']
     * @param  string  $param['account_id']
     * @param  string  $param['manager_account_id']
     * @param  string  $param['manager_ip']
     *
     * @return json
     */
     public function cancelAccount() {
        $accountType = I('post.account_type', '');
        $accountID = I('post.account_id', '');
        $managerID = I('post.manager_account_id', '');
        $managerIP = I('post.manager_ip', '');
        try {
            if (empty($accountID)) {
                ExceptionHandler::make_throw('5401');
            }
            if (empty($managerID)) {
                ExceptionHandler::make_throw('0001');
            }
            if (empty($managerIP)) {
                ExceptionHandler::make_throw('0002');
            }
            $res =  D('AccountOption', 'Service')->cancelAccount($accountType, $accountID, $managerID, $managerIP);
        } catch (\Exception $e) {
            $this->returnException($e);
        }
        $this->returnResponse($res);
     }

    /**
     * 重置密码
     *
     * @param  string  $param['account_type']
     * @param  int  $param['account_id']
     * @param  string  $param['manager_account_id']
     * @param  string  $param['manager_ip']
     * @param  string  $param['pwd_new']
     *
     * @return mix
     */
     public function resetPassword() {
        $accountType = I('post.account_type', '');
        $accountID = I('post.account_id', '');
        $managerID = I('post.manager_account_id', '');
        $managerIP = I('post.manager_ip', '');
        $pwdNew = I('post.pwd_new', '');
        try {
            if (empty($accountID)) {
                ExceptionHandler::make_throw('5501');
            }
            if (empty($managerID)) {
                ExceptionHandler::make_throw('0001');
            }
            if (empty($managerIP)) {
                ExceptionHandler::make_throw('0002');
            }
            if (empty($pwdNew)) {
                ExceptionHandler::make_throw('5502');
            }
            $res =  D('AccountOption', 'Service')->changePassword($accountType, $accountID, $managerID, $managerIP, $pwdNew);
        } catch (\Exception $e) {
            $this->returnException($e);
        }
        $this->returnResponse($res);
     }

    /**
     * 更新账号资料
     *
     * @param  string  $param['account_type']
     * @param  int  $param['account_id']
     *
     * @return mix
     */
     public function changeUserInfo() {
        $accountType = I('post.account_type', '');
        $params = array(
            'account_id' => I('post.account_id', ''),
            'manager_ip' =>  isset($_POST['manager_ip']) ? $_POST['manager_ip'] : get_client_ip(),
        );
        if (isset($_POST['account_name'])) $params['account_name'] = $_POST['account_name'];
        if (isset($_POST['mobile'])) $params['mobile'] = $_POST['mobile'];
        if (isset($_POST['email'])) $params['email'] = $_POST['email'];
        if (isset($_POST['account_avatar'])) $params['account_avatar'] = $_POST['account_avatar'];
        if (isset($_POST['nick_name'])) $params['nick_name'] = $_POST['nick_name'];
        if (isset($_POST['real_name'])) $params['real_name'] = $_POST['real_name'];
        if (isset($_POST['sex'])) $params['sex'] = $_POST['sex'];
        if (isset($_POST['province_id'])) $params['province_id'] = $_POST['province_id'];
        if (isset($_POST['city_id'])) $params['city_id'] = $_POST['city_id'];
        if (isset($_POST['address'])) $params['address'] = $_POST['address'];
        if (isset($_POST['u_idcard'])) $params['u_idcard'] = $_POST['u_idcard'];
        if (isset($_POST['manager_account_id'])) $params['manager_account_id'] = $_POST['manager_account_id'];

        try {
            if (empty($params['account_id'])) {
                ExceptionHandler::make_throw('5101');
            }
            if (empty($params['manager_account_id'])) {
                ExceptionHandler::make_throw('0001');
            }
            if (empty($params['manager_ip'])) {
                ExceptionHandler::make_throw('0002');
            }
            $res =  D('AccountOption', 'Service')->changeUserInfo($accountType, $params);
        } catch (\Exception $e) {
            $this->returnException($e);
        }
        $this->returnResponse($res);
     }

}
