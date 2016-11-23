<?php
/**
 * 短信验证服务
 *
 * 提供获取验证码、发送验证码、审核验证码等功能
 *
 * @category API
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
namespace SMS\Controller;

use Base\ExceptionHandler;

class IndexController extends CommonController {

    public function __construct() 
    {
        $this->checkApiToken();
    }

    /**
     * 发送短信通知
     * @param int $_POST['number'] 短信编号
     * @param int $_POST['mobile'] 短信接收人电话
     * @param string $_POST['content_params'] 短信模板参数
     * 
     * @return json
     */
     public function sendNotification() {
        $number = I('post.number', '');
        $mobile = I('post.mobile', '', 'urlencode');
        $params = $_POST['content_params'];
        try {
            if (empty($number)) {
                ExceptionHandler::make_throw('0002');
            }
            if (empty($mobile)) {
                ExceptionHandler::make_throw('0006');
            }
            $rs =  D('MsgGateWay', 'Service')->msgSend($mobile, $number, $params);
            if (!$rs) {
                ExceptionHandler::make_throw('0012');   
            }
        } catch (\Exception $e) {
            $this->returnException($e);
        }
        $this->returnResponse(true);
     }

    /**
     * 发送短信验证码
     * @param int $_POST['number'] 短信编号
     * @param int $_POST['mobile'] 短信接收人电话
     * 
     * @return json
     */
     public function sendVerifyCode() {
        $number = I('post.number', '');
        $mobile = I('post.mobile', '', 'urlencode');
        try {
            if (empty($number)) {
                ExceptionHandler::make_throw('0002');
            }
            if (empty($mobile)) {
                ExceptionHandler::make_throw('0006');
            }
            $res =  D('MsgGateWay', 'Service')->codeSend($mobile, $number); // 返回产生的验证码
            if (!$res) {
                ExceptionHandler::make_throw('0013');
            }
        } catch (\Exception $e) {
            $this->returnException($e);
        }
        $this->returnResponse($res);
     }

    /**
     * 校验短信验证码
     * @param int $_POST['number'] 短信编号
     * @param int $_POST['mobile'] 短信接收人电话
     * @param int $_POST['verification_code'] 短信验证码
     * 
     * @return json
     */
     public function verifyCode() {
        $number = I('post.number', '');
        $mobile = I('post.mobile', '', 'urlencode');
        $verCode = I('post.ver_code', '');
        try {
            if (empty($number)) {
                ExceptionHandler::make_throw('0002');
            }
            if (empty($mobile)) {
                ExceptionHandler::make_throw('0006');
            }
            if (empty($verCode)) {
                ExceptionHandler::make_throw('0085');
            }
            $res =  D('MsgGateWay', 'Service')->verifyCode($number, $mobile, $verCode);
        } catch (\Exception $e) {
            $this->returnException($e);
        }
        $this->returnResponse($res);
     }

}
