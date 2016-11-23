<?php
/**
 * 用户账号操作模型
 * 
 * @category API
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
namespace SMS\Utest\Service;

use Think\UnitTest;
use \Common\Org\Request;
use \Common\Org\PhpRedis;

class MsgGateWayService extends UnitTest {
    private $Redis;
    private $mob_code_key = 'mob_code_';
    private $_datas = array();


    function index(){
        //通过自动遍历测试类的方式执行测试
        $this->run(true);
    }

    //前置操作方法    
    public function __construct() {
        $this->Redis = new PhpRedis();
    }

    public function test_cmsgSend() {
        // 发送成功
        $number = 1;
        $mobile = '15029911786';
        $params =  array(
            'username' => 'sean',
            'password' => '111111',
        );
        try {
            $res =  D('MsgGateWay', 'Service')->msgSend($mobile, $number, $params);
        } catch (\Exception $e) {
            $res = array(
                'code' => $e->getCode(),
                'msg' => $e->getMessage(),
                'data' => array(),
            );
        }
        $this->assertNotEmpty($res, '发送短信: 发送成功');
        // 电话号码异常
        $number = 1;
        $mobile = '15029911786abc';
        $params =  array(
            'username' => 'sean',
            'password' => '111111',
        );
        try {
            $res =  D('MsgGateWay', 'Service')->msgSend($mobile, $number, $params);
        } catch (\Exception $e) {
            $res = array(
                'code' => $e->getCode(),
                'msg' => $e->getMessage(),
                'data' => array(),
            );
            $this->assertEquals('120006', $res['code'], '发送短信: '. $res['msg']);
        }
        // 短信类型编号异常
        $number = 'xxx';
        $mobile = '15029911786';
        $params =  array(
            'username' => 'sean',
            'password' => '111111',
        );
        try {
            $res =  D('MsgGateWay', 'Service')->msgSend($mobile, $number, $params);
        } catch (\Exception $e) {
            $res = array(
                'code' => $e->getCode(),
                'msg' => $e->getMessage(),
                'data' => array(),
            );
            $this->assertEquals('120002', $res['code'], '发送短信: '. $res['msg']);
        }
        // 短信模板参数异常
        $number = 20;
        $mobile = '15029911786';
        $params =  array(
            'username' => 'sean',
            'password' => '111111',
        );
        try {
            $res =  D('MsgGateWay', 'Service')->msgSend($mobile, $number, $params);
        } catch (\Exception $e) {
            $res = array(
                'code' => $e->getCode(),
                'msg' => $e->getMessage(),
                'data' => array(),
            );
            $this->assertEquals('120003', $res['code'], '发送短信: '. $res['msg']);
        }
    }

    public function test_codeSend() {
        // 发送成功
        $number = 13;
        $mobile = '15029911786';
        try {
            $res =  D('MsgGateWay', 'Service')->codeSend($mobile, $number);
        } catch (\Exception $e) {
            $res = array(
                'code' => $e->getCode(),
                'msg' => $e->getMessage(),
                'data' => array(),
            );
            $quota = $this->Redis->get($this->mob_code_key . 'num_' . $mobile);
            if ($quota) {
                $quota_data = json_decode($quota, true);
                $time_60s = time() - $quota_data['time'];
                if ($time_60s < 60) {
                    $this->assertEquals('120090', $res['code'], '发送短信: '. $res['msg']);
                }
                if ($quota_data['num'] > 10) {
                    $this->assertEquals('120088', $res['code'], '发送短信: '. $res['msg']);
                }
            }            
        }
        if ($res === true) {
            $this->assertTrue($res, '发送短信: 验证码成功');
        }
        // 电话号码异常
        $number = 13;
        $mobile = '15029911786abc';
        try {
            $res =  D('MsgGateWay', 'Service')->msgSend($mobile, $number);
        } catch (\Exception $e) {
            $res = array(
                'code' => $e->getCode(),
                'msg' => $e->getMessage(),
                'data' => array(),
            );
            $this->assertEquals('120006', $res['code'], '发送短信: '. $res['msg']);
        }
        // 短信类型编号异常
        $number = 'xxx';
        $mobile = '15029911786';
        try {
            $res =  D('MsgGateWay', 'Service')->msgSend($mobile, $number);
        } catch (\Exception $e) {
            $res = array(
                'code' => $e->getCode(),
                'msg' => $e->getMessage(),
                'data' => array(),
            );
            $this->assertEquals('120002', $res['code'], '发送短信: '. $res['msg']);
        }
        // 短信模板参数异常
        $number = 20;
        $mobile = '15029911786';
        try {
            $res =  D('MsgGateWay', 'Service')->msgSend($mobile, $number);
        } catch (\Exception $e) {
            $res = array(
                'code' => $e->getCode(),
                'msg' => $e->getMessage(),
                'data' => array(),
            );
            $this->assertEquals('120003', $res['code'], '发送短信: '. $res['msg']);
        }
    }

}