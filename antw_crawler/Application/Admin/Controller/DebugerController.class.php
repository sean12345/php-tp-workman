<?php
/**
 * 接口调试工具
 *
 *
 * @category API
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
namespace Admin\Controller;

use Base\ExceptionHandler;
use \Common\Org\Request;
use \Common\Org\Xcrypt;

class DebugerController extends CommonController {

    protected $allowMethod = array('get', 'post');

    protected $allowType = array('html');

    /**
     * 调试工具界面
     * 
     * @return mix
     */
    public function show(){
        $this->isLogin();
        $this->display('show');
     }

     /**
      * 处理请求
      * 
      */
     public function apiRequest() {
        $this->isLogin();
        $apiUrl = I('post.api_url', '');
        $appKey = I('post.app_key', '');
        $secretKey = I('post.secret_key', '');
        $isPost =  I('post.request_type', '') == 'POST' ? 1 : 0;
        $params = I('post.request_params', '', 'strip_tags');
        try {
            if (empty($apiUrl)) {
                ExceptionHandler::make_throw('0001');
            }
            if (empty($secretKey) || !in_array(strlen($secretKey), array(8, 16, 32)) ) {
                ExceptionHandler::make_throw('100012');
            }
            $requestObj = new Request($appKey, $secretKey);
            $res = $requestObj->juhecurl($apiUrl, $params, $isPost);
        } catch (\Exception $e) {
            $this->returnException($e);
        }
        echo $res; exit;
     }

}