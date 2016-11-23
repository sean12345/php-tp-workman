<?php
/**
 * 用户活动
 * 用户中心账号服务
 *
 * 提供账号注册、登录、退出、账号信息查询等功能
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
use Common\Org\Xcrypt;

class AccountActionController extends CommonController {

    public function _initialize() {
        $this->checkApiToken();
    }

    /**
     * 获取账号信息
     *
     * @param  string  $param['account_type']
     * @param  string  $param['account_id']
     * @param  string  $param['mobile']
     * @param  string  $param['account_name']
     *
     * @return json
     */
     public function checkAccount() {
        $accountType = I('get.account_type', '');
        $accountID = I('get.account_id', '');
        $accountName = I('get.account_name', '');
        $mobile = I('get.mobile', '');
        $res = false;
        try {
            if (empty($accountType)) {
                ExceptionHandler::make_throw('1106');
            }
            if ($accountID) {
                $re_01 =  D('AccountAction', 'Service')->getAccountInfo($accountType, $accountID);
            } elseif ($mobile) {
                $re_02 =  D('AccountAction', 'Service')->getAccountInfoByMobile($accountType, $mobile);
            } elseif ($accountName) {
                $re_03 =  D('AccountAction', 'Service')->getAccountInfoByAccountName($accountType, $accountName);
            }
            if ($re_01 || $re_02 || $re_03) {
                $res = true;
            } else {                
                ExceptionHandler::make_throw('1105');
            }
        } catch (\Exception $e) {
            $this->returnException($e);
        }
        $this->returnResponse($res);
     }

    /**
     * 获取账号信息
     *
     * @param  string  $param['account_id']
     * @param  string  $param['account_name'] // 需求来源：运营平台需要按用户名搜索
     * @param  string  $param['account_type']
     *
     * @return json
     */
     public function getAccountInfo() {
        $res = array();
        $accountID = I('get.account_id', '');
        $accountName = I('get.account_name', '');
        $accountType = I('get.account_type', '');
        try {
            if (empty($accountID) && empty($accountName)) {
                ExceptionHandler::make_throw('1107');
            }

            if (empty($accountType)) {
                ExceptionHandler::make_throw('1106');
            }
            if ($accountID) {
                $info =  D('AccountAction', 'Service')->getAccountInfo($accountType, $accountID);
            } elseif ($accountName) {
                $info =  D('AccountAction', 'Service')->getAccountInfoByAccountName($accountType, $accountName);
            }
            if ($info) $res = $info;
        } catch (\Exception $e) {
            $this->returnException($e);
        }
        $this->returnResponse($res);
     }

    /**
     * 批量获取账号信息
     *
     * @param  array  $param['account_id']
     * @param  string  $param['account_type']
     *
     * @return json
     */
    public function getBatchAccountInfo()
    {
        $accountID = I('post.account_id', '');
        $accountType = I('post.account_type', '');
        $accountName = I('post.account_name', '');

        $page = I('post.page', 1);
        $pageSize = I('post.page_size', 0);

        try {
//            if (empty($accountID) && empty($accountName)) {
//                ExceptionHandler::make_throw('1101');
//            }
            if (empty($accountType)) {
                ExceptionHandler::make_throw('1106');
            }
            if ($accountID || $accountName) {
                $res =  D('AccountAction', 'Service')->getBatchAccountInfo($accountType, $accountID, $accountName, $page, $pageSize);
            }
        } catch (\Exception $e) {
            $this->returnException($e);
        }
        $this->returnResponse($res);
    }


    /**
     * 获取账号密码
     *
     * @param  string  $param['user_name']
     * @param  string  $param['account_type']
     *
     * @return json
     */
     public function getAccountPwd() {
        $userName = I('get.user_name', '');
        $accountType = I('get.account_type', '');
        try {
            $res =  D('AccountAction', 'Service')->getAccountPwd($accountType, $userName);
        } catch (\Exception $e) {
            $this->returnException($e);
        }
        $this->returnResponse($res);
     }

    /**
     * 注册新账号
     *
     * @param  string  $param['account_name']
     * @param  string  $param['email']
     * @param  string  $param['mobile']
     * @param  string  $param['account_type']
     * @param  string  $param['pwd']
     *
     * @return json
     */
     public function registAccount() {
        $params = array(
            'account_name' => I('post.account_name', ''),
            'mobile' => I('post.mobile', ''),
            'email' => I('post.email', ''),
            'pwd' => I('post.pwd', ''),
            'login_ip' => get_client_ip()
        );
        $accountType = I('post.account_type', '');
        try {
            if (empty($accountType)) {
                ExceptionHandler::make_throw('0110');
            }
            switch ($accountType) {
                case CommonService::ACCOUNT_TYPE_WEB: // 官网用户: 注册时手机号必填，并以手机号作为登录名
                    if (empty($params['mobile'])) {
                        ExceptionHandler::make_throw('0104');
                    }                
                    break;
                case CommonService::ACCOUNT_TYPE_DEALER: // 车商: 注册时账号名、手机号必填，邮箱选填
                case CommonService::ACCOUNT_TYPE_4S: // 4S店: 注册时账号名、手机号必填，邮箱不填
                case CommonService::ACCOUNT_TYPE_EMPLOYEE: // 员工: 注册时账号名、手机号必填，邮箱不填

                    // 注册时账号名、手机号、邮箱不能同时为空
                    if (empty($params['account_name']) && empty($params['mobile']) && empty($params['email'])) {
                        ExceptionHandler::make_throw('0116');   
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
                    // if (empty($params['account_name'])) {
                    //     ExceptionHandler::make_throw('0101');
                    // }
                    // if (empty($params['mobile'])) {
                    //     ExceptionHandler::make_throw('0104');
                    // }
                    break;            
                default:
                    ExceptionHandler::make_throw('0111');
                    break;
            }
            $accountID =  D('AccountAction', 'Service')->registAccount($accountType, $params);
        } catch (\Exception $e) {
            $this->returnException($e);
        }
        if ($accountID) {
            // $res = array ('account_id' => $accountID);
            $res = D('AccountAction', 'Service')->getAccountInfo($accountType, $accountID);
        } else {
            $res = false;
        }
        $this->returnResponse($res);
     }

    /**
     * 用户登录
     *
     * @param  int  $param['account_type']
     * @param  string  $param['user_name']
     * @param  string  $param['pwd']
     *
     * @return json
     */
     public function accountLogin() {
        $userName = I('post.user_name', '');
        $pwd = I('post.pwd', '');
        $accountType = I('post.account_type', '');
        try {
            if (empty($accountType)) {
                ExceptionHandler::make_throw('0207');
            }
            if (empty($userName)) {
                ExceptionHandler::make_throw('0201');
            }
            if (empty($pwd)) {
                ExceptionHandler::make_throw('0209');
            }
            $res =  D('AccountAction', 'Service')->accountLogin($accountType, $userName, $pwd);
        } catch (\Exception $e) {
            $this->returnException($e);
        }
        $this->returnResponse($res);
     }

    /**
     * 用户退出
     *
     * @param  int  $param['account_type']
     * @param  int  $param['account_id']
     *
     * @return mix
     */
     public function accountLogout() {
        $accountID = I('post.account_id', '');
        $accountType = I('post.account_type', '');
        try {
            if (empty($accountType)) {
                ExceptionHandler::make_throw('0303');
            }
            if (empty($accountID)) {
                ExceptionHandler::make_throw('0301');
            }
            $res =  D('AccountAction', 'Service')->accountLogout($accountType, $accountID);
        } catch (\Exception $e) {
            $this->returnException($e);
        }
        $this->returnResponse($res);
     }

    /**
     * 找回密码
     *
     * @param  int  $param['mobile']
     * @param  int  $param['account_type']
     * @param  string  $param['ver_code'] // 手机验证码 (已取消，在上层应用中完成验证)
     * @param  string  $param['number'] // 验证码类型编号
     * @param  string  $param['pwd_new']
     *
     * @return mix
     */
     public function retrievePassword() {
        $mobile = I('post.mobile', '');
        $accountType = I('post.account_type', '');
        // $verCode = I('post.ver_code', '');
        $number = I('post.number', '');
        $pwdNew = I('post.pwd_new', '');
        try {
            if (empty($number)) {
                ExceptionHandler::make_throw('0709');
            }
            if (empty($mobile)) {
                ExceptionHandler::make_throw('0701');
            }
            if (empty($accountType)) {
                ExceptionHandler::make_throw('0706');
            }
            if (empty($pwdNew)) {
                ExceptionHandler::make_throw('0704');
            }
            // $checkVerCode = D('SMS/MsgGateWay', 'Service')->verifyCode($number, $mobile, $ver_code);
            // if (!$checkVerCode) {
            //     ExceptionHandler::make_throw('0703');
            // }
            // $apiUrl = C('VER_CODE_URL');
            // $params = array(
            //                             'number' => $number,
            //                             'mobile' => $mobile,
            //                             'ver_code' => $verCode,
            //                         );
            // $appkey = C('APPKEY');
            // $secretkey = C('SECRETKEY');
            // $requestObj = new Request($appkey, $secretkey);
            // $rs = $requestObj->juhecurl($apiUrl, json_encode($params), 1);
            // $rs = json_decode($rs, true);
            // if (!isset($rs['code']) || $rs['code'] != '000000') {
            //     ExceptionHandler::make_throw('0703');
            // }
            $res =  D('AccountAction', 'Service')->resetPassword($accountType, $mobile, $pwdNew);
        } catch (\Exception $e) {
            $this->returnException($e);
        }
        $this->returnResponse($res);
     }


    /**
     * 修改密码
     *
     * @param  int  $param['account_type']
     * @param  int  $param['account_id']
     * @param  string  $param['pwd_old']
     * @param  string  $param['pwd_new']
     *
     * @return mix
     */
     public function changePassword() {
        $accountType = I('post.account_type', '');
        $accountID = I('post.account_id', '');
        $pwdOld = I('post.pwd_old', '');
        $pwdNew = I('post.pwd_new', '');
        try {
            if (empty($accountID)) {
                ExceptionHandler::make_throw('0801');
            }
            if (empty($pwdOld)) {
                ExceptionHandler::make_throw('0803');
            }
            if (empty($pwdNew)) {
                ExceptionHandler::make_throw('0805');
            }
            if ($pwdNew == $pwdOld) {
                ExceptionHandler::make_throw('0807');
            }
            $res =  D('AccountAction', 'Service')->changePassword($accountType, $accountID, $pwdOld, $pwdNew);
        } catch (\Exception $e) {
            $this->returnException($e);
        }
        $this->returnResponse($res);
     }

    /**
     * 更新账号资料
     *
     * @param  int  $param['account_id']
     * @param  string  $param[...]
     *
     * @return mix
     */
    public function changeInfo()
    {
        $accountType = I('post.account_type', '');
        $params = array(
            'account_id' => I('post.account_id', ''),
            'login_ip' => get_client_ip(),
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
        try {
            if (empty($params['account_id'])) {
                ExceptionHandler::make_throw('0901');
            }
            $res = D('AccountAction', 'Service')->changeInfo($accountType, $params);
        } catch (\Exception $e) {
            $this->returnException($e);
        }
        $this->returnResponse($res);
    }

}
