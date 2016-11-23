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

    /**
     * 调试工具界面(文件传输)
     * 
     * @return mix
     */
    public function fshow(){
        $this->isLogin();
        $this->display('show_file_upload');
     }

     /**
      * 处理请求(文件传输)
      * 
      */
     public function fapiRequest() {
        $this->isLogin();
        $apiUrl = I('post.api_url', '');
        $appKey = I('post.app_key', '');
        $secretKey = I('post.secret_key', '');
        $isPost =  I('post.request_type', '') == 'POST' ? 1 : 0;
        $params = I('post.request_params', '', 'strip_tags');

        $paramsArr = json_decode($params, true);
        if ( !empty($_FILES['file_01']) && $_FILES['file_01']['size'] > 0) {
            $fileInfo = array(
                'file_name' => $_FILES['file_01']['name'],
                'file_type' => $_FILES['file_01']['type'],
                // 'file_content' => base64_encode(file_get_contents($_FILES["file_01"]["tmp_name"])),
                'file_content' => base64_encode(file_get_contents($_FILES["file_01"]["tmp_name"])),
                // 'file_content' => file_get_contents($_FILES["file_01"]["tmp_name"]),
                'file_size' => $_FILES['file_01']['size'],
            );
            // $strFileInfo = json_encode($fileInfo);
            // $strFileInfo = json_encode($_FILES['file_01']);

            // $paramsArr['file_info'] = base64_encode($strFileInfo);
            $paramsArr['file_info'] = $fileInfo;

            $paramsArr = array(
                'app_type' => '1',
                'source_path' => 'a/b/c',
                'file_suffix' => '.jpg',
                'file_content' => base64_encode(file_get_contents($_FILES["file_01"]["tmp_name"])),
                'code_md5' => md5(file_get_contents($_FILES["file_01"]["tmp_name"])),
            );
        }

        $params = json_encode($paramsArr);

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