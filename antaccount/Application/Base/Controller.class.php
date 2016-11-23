<?php
/**
 * ant-nest基础控制器
 *
 * 提供控制层功能处理
 *
 * @category API
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
namespace Base;

use Think\Controller\RestController;

class Controller extends RestController {

    public function _empty($name)
    {
        $codePrefixList = C('EXCEPTION_CODE_PREFIX');
        $code = '0001';
        $fullCode = $codePrefixList['ANTNEST'] . $code;
        $msgList = C('SYS_EXCEPTION_CODE');
        $data = array(
            'code' => $fullCode,
            'msg' => $msgList[$code],
            'data' => array(),
        );
        $this->response($data, 'json');
    }

    protected function returnResponse($data) {
            if (is_array($data) || $data === true) {
                $this->returnSuccess($data);
            } else {
                $this->returnFaild();
            }
    }

    protected function returnSuccess($data=array()) {
            $data = array(
                'code' => '000000',
                'msg' => 'ok',
                'data' => (!empty($data) && is_array($data)) ? $data : array(),
            );
            $this->response($data, 'json');
    }

    protected function returnFaild() {
            $data = array(
                'code' => '-1',
                'msg' => '当前请求处理失败',
                'data' => array(),
            );
            $this->response($data, 'json');
    }

    protected function returnException($e) {
        $data = array(
            'code' => $e->getCode(),
            'msg' => $e->getMessage(),
            'data' => array(),
        );
        $this->response($data, 'json');
    }

    public function checkApiToken() {

        // TOTO 临时屏蔽 方便客户端调试业务-----------------------------
         $appKey = I('server.HTTP_APPKEY');
         if (!empty($appKey) && $appKey == 'AK2016.API.1005') {
            return true;
         }
         //---------------------------------------------------------------------------------

        try {
            $token = I('server.HTTP_TOKEN');
            if (empty($token)) {
                ExceptionHandler::make_throw('100010');
            }
            $authInfo = C('AUTHORIZATION_API_COMMON');
            $appKey = I('server.HTTP_APPKEY'); // 在服务器端用该appkey获取对应的secretkey, 如果获取不到则证明该appkey无效
            if (empty($appKey) || !array_key_exists($appKey, $authInfo) ) {
                ExceptionHandler::make_throw('100011');
            }
            $appAuth = $authInfo[$appKey];
            $secretKey = !empty($appAuth['secret_key']) ? $appAuth['secret_key'] : '';
            $m = new \Common\Org\Xcrypt($secretKey, 'ecb', 'auto');
            $accessKey = $m->decrypt($token, 'base64');
            if (!$accessKey) {
                 ExceptionHandler::make_throw('100011');
            }
            $arrKeysDec = explode('_', $accessKey);
            $appKeyDec = !empty($arrKeysDec[0]) ? $arrKeysDec[0] : '';
            $secretKeyDec = !empty($arrKeysDec[1]) ? $arrKeysDec[1] : '';
            $timeClientDec = !empty($arrKeysDec[2]) ? $arrKeysDec[2] : '';
            if ($secretKeyDec != $secretKey) {
                ExceptionHandler::make_throw('100012');
            }
            if ((time() - $timeClientDec) > 60*2) {
                ExceptionHandler::make_throw('100013');
            }
        } catch (\Exception $e) {
            $this->returnException($e);
        }                  
        return true;
    }


}