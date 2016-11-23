<?php
/**
 * 短信操作
 * 
 * @category API
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
namespace SMS\Utest\Controller;

use Think\UnitTest;
use \Common\Org\Request;

class IndexController extends UnitTest {

    private $_datas = array();
    private $_appKey = 'AK2016.API.1001';
    private $_secretKey = 'ax1001erttt643ee';

    function index(){
        //通过自动遍历测试类的方式执行测试
        $this->run(true);
    }

    //前置操作方法    
    public function __construct() {
        // $this->prepareData();
        // $this->test_registAccount();
    }

    private function prepareData() {
    }

    public function test_sendNotification() {
        $dataFile = MODULE_PATH . "Utest" . DIRECTORY_SEPARATOR . "Data" . DIRECTORY_SEPARATOR . "msg_notify.json";
        $contents = file_get_contents($dataFile);
        $datas = json_decode($contents, true);
        $this->assertNotEmptyArray($datas, '初始化测试数据');
        foreach ($datas as $key => $item) {
            $apiUrl = 'http://' . $_SERVER['SERVER_NAME'] . '/' . $item['uri'];
            $isPost = $item['method'] == 'POST' ? 1 : 0;
            $data = $item['params'];
            // 激活成功
            $params = array(
                'number' => $data['number'],
                'mobile' => $data['mobile'],
                'content_params' => $data['content_params'],
            );
            $requestObj = new Request($this->_appKey, $this->_secretKey);
            $res = $requestObj->juhecurl($apiUrl, json_encode($params), $isPost);
            $res = json_decode($res, true);
            $re = $this->getTestResult();
            $this->assertEquals($item['responses']['code'], $res['code'], $item['responses']['msg']);
        }
    }

    public function test_sendVerifyCode() {
        $dataFile = MODULE_PATH . "Utest" . DIRECTORY_SEPARATOR . "Data" . DIRECTORY_SEPARATOR . "msg_send_verify.json";
        $contents = file_get_contents($dataFile);
        $datas = json_decode($contents, true);
        $this->assertNotEmptyArray($datas, '初始化测试数据');
        foreach ($datas as $key => $item) {
            $apiUrl = 'http://' . $_SERVER['SERVER_NAME'] . '/' . $item['uri'];
            $isPost = $item['method'] == 'POST' ? 1 : 0;
            $data = $item['params'];
            $params = array(
                'number' => $data['number'],
                'mobile' => $data['mobile']
            );
            $requestObj = new Request($this->_appKey, $this->_secretKey);
            $res = $requestObj->juhecurl($apiUrl, json_encode($params), $isPost);
            $res = json_decode($res, true);
            $re = $this->getTestResult();
            $this->assertEquals($item['responses']['code'], $res['code'], $item['responses']['msg']);
        }
    }

    public function test_verifyCode() {
        $dataFile = MODULE_PATH . "Utest" . DIRECTORY_SEPARATOR . "Data" . DIRECTORY_SEPARATOR . "msg_verify_code.json";
        $contents = file_get_contents($dataFile);
        $datas = json_decode($contents, true);
        $this->assertNotEmptyArray($datas, '初始化测试数据');
        foreach ($datas as $key => $item) {
            $apiUrl = 'http://' . $_SERVER['SERVER_NAME'] . '/' . $item['uri'];
            $isPost = $item['method'] == 'POST' ? 1 : 0;
            $data = $item['params'];
            // 激活成功
            $params = array(
                'number' => $data['number'],
                'mobile' => $data['mobile'],
                'ver_code' => $data['ver_code'],
            );
            $requestObj = new Request($this->_appKey, $this->_secretKey);
            $res = $requestObj->juhecurl($apiUrl, json_encode($params), $isPost);
            $res = json_decode($res, true);
            $re = $this->getTestResult();
            $this->assertEquals($item['responses']['code'], $res['code'], $item['responses']['msg']);
        }
    }

}