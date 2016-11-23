<?php
/**
 * 用户账号操作
 * 
 * @category API
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
namespace Ucenter\Utest\Controller;

use Think\UnitTest;
use \Admin\Org\Request;

class AccountController extends UnitTest {

    private $_datas = array();

    function index(){
        //通过自动遍历测试类的方式执行测试
        $this->run(true);
    }

    //前置操作方法    
    public function __construct() {
        $this->prepareData();
        $this->test_registAccount();
    }

    private function prepareData() {
        $dataFile = MODULE_PATH . "Utest" . DIRECTORY_SEPARATOR . "Data" . DIRECTORY_SEPARATOR . "createAccount.json";
        $contents = file_get_contents($dataFile);
        $this->_datas = json_decode($contents, true);
        $res = true;
        foreach ($this->_datas as $item) {
            //按account_name和mobile清空账号数据
            $cond = array(
                'account_name' => $item['params']['account_name'],
                'mobile' => $item['params']['mobile'],
                '_logic' =>'or',
            );
            $accountIds = D('AntNest\Account', 'Model')->where($cond)->getField('account_id');
            $reAccount = D('AntNest\Account', 'Model')->where($cond)->delete();
            $cond = array(
                'account_id' => is_array($accountIds) ? array('in', $accountIds) : $accountIds
            );
            $reLog = D('AntNest\AccountLog', 'Model')->where($cond)->delete();
            if ($reAccount === false || $reLog === false) {
                $res = false;
            }
        }
        $this->assertTrue($res, '初始化测试数据');
    }

    private function test_registAccount() {
        foreach ($this->_datas as $key => $item) {
            $apiUrl = 'http://' . $_SERVER['SERVER_NAME'] . '/' . $item['uri'] . '/add';
            $isPost = $item['method'] == 'POST' ? 1 : 0;
            $params = json_encode($item['params']);
            $expect = $item['responses'];
            $res = Request::juhecurl($apiUrl, $params, $isPost);
            $res = json_decode($res, true);
            $re = $this->getTestResult();
            switch ($res['code']) {
                case '000000':
                    $this->assertEquals($expect['code'], $res['code'], '用户账号注册:注册成功');
                    $this->_datas[$key]['params']['account_id'] = $res['data']['account_id'];
                    break;
                case '130007':
                    $this->assertEquals($expect['code'], $res['code'], '用户账号注册:'.$res['msg']);
                    unset($this->_datas[$key]);
                    break;                
                default:
                    break;
            }
        }
    }

    public function test_activeAccount() {
        foreach ($this->_datas as $key => $item) {
            $apiUrl = 'http://' . $_SERVER['SERVER_NAME'] . '/' . $item['uri'] . '/active';
            $isPost = $item['method'] == 'POST' ? 1 : 0;
            $data = $item['params'];
            // 激活成功
            $params = array(
                'account_id' => $data['account_id']
            );
            $params = json_encode($params);
            $res = Request::juhecurl($apiUrl, $params, $isPost);
            $res = json_decode($res, true);
            $re = $this->getTestResult();
            $this->assertEquals('000000', $res['code'], '用户账号激活: 激活成功');
            // 账号无效
            $params = array(
                'account_id' => ''
            );
            $params = json_encode($params);
            $res = \Admin\Org\Request::juhecurl($apiUrl, $params, $isPost);
            $res = json_decode($res, true);
            $this->assertEquals('130001', $res['code'], '用户账号激活: '. $res['msg']);
            // 重复激活
            $params = array(
                'account_id' => $data['account_id']
            );
            $params = json_encode($params);
            $res = \Admin\Org\Request::juhecurl($apiUrl, $params, $isPost);
            $res = json_decode($res, true);
            $this->assertEquals('130010', $res['code'], '用户账号激活: '. $res['msg']);
        }
    }

    public function test_accountLogin() {
        foreach ($this->_datas as $key => $item) {
            $apiUrl = 'http://' . $_SERVER['SERVER_NAME'] . '/' . $item['uri'] . '/login';
            $isPost = $item['method'] == 'POST' ? 1 : 0;
            $data = $item['params'];
            // 登录成功
            $params = array(
                'account_name' => $data['account_name'],
                'account_type' => $data['account_type'],
                'pwd' => $data['pwd']
            );
            $params = json_encode($params);
            $res = Request::juhecurl($apiUrl, $params, $isPost);
            $res = json_decode($res, true);
            $re = $this->getTestResult();
            $this->assertEquals('000000', $res['code'], '用户登录: 登录成功');
            // 用户名错误
            $params = array(
                'account_name' => '',
                'account_type' => $data['account_type'],
                'pwd' => $data['pwd']
            );
            $params = json_encode($params);
            $res = Request::juhecurl($apiUrl, $params, $isPost);
            $res = json_decode($res, true);
            $re = $this->getTestResult();
            $this->assertEquals('130013', $res['code'], '用户登录: '. $res['msg']);
            // 密码错误
            $params = array(
                'account_name' => $data['account_name'],
                'account_type' => $data['account_type'],
                'pwd' => ''
            );
            $params = json_encode($params);
            $res = Request::juhecurl($apiUrl, $params, $isPost);
            $res = json_decode($res, true);
            $re = $this->getTestResult();
            $this->assertEquals('130002', $res['code'], '用户登录: '. $res['msg']);
            // 账号类型无效
            $params = array(
                'account_name' => $data['account_name'],
                'account_type' => '',
                'pwd' => '123456'
            );
            $params = json_encode($params);
            $res = Request::juhecurl($apiUrl, $params, $isPost);
            $res = json_decode($res, true);
            $re = $this->getTestResult();
            $this->assertEquals('130017', $res['code'], '用户登录: '. $res['msg']);
        }
    }

    public function test_accountLogout() {
        foreach ($this->_datas as $key => $item) {
            $apiUrl = 'http://' . $_SERVER['SERVER_NAME'] . '/' . $item['uri'] . '/logout';
            $isPost = $item['method'] == 'POST' ? 1 : 0;
            $data = $item['params'];
            // 退出登录成功
            $params = array(
                'account_id' => $data['account_id'],
                'account_type' => $data['account_type'],
            );
            $params = json_encode($params);
            $res = Request::juhecurl($apiUrl, $params, $isPost);
            $res = json_decode($res, true);
            $re = $this->getTestResult();
            $this->assertEquals('000000', $res['code'], '退出登录: 退出登录成功');
            // 账号ID错误
            $params = array(
                'account_id' => '',
                'account_type' => $data['account_type'],
            );
            $params = json_encode($params);
            $res = Request::juhecurl($apiUrl, $params, $isPost);
            $res = json_decode($res, true);
            $re = $this->getTestResult();
            $this->assertEquals('130001', $res['code'], '退出登录: '. $res['msg']);
            // 账号类型错误
            $params = array(
                'account_id' => $data['account_id'],
                'account_type' => ''
            );
            $params = json_encode($params);
            $res = Request::juhecurl($apiUrl, $params, $isPost);
            $res = json_decode($res, true);
            $re = $this->getTestResult();
            $this->assertEquals('130017', $res['code'], '退出登录: '. $res['msg']);
        }
    }

    public function test_inactiveAccount() {
        foreach ($this->_datas as $key => $item) {
            $apiUrl = 'http://' . $_SERVER['SERVER_NAME'] . '/' . $item['uri'] . '/inactive';
            $isPost = $item['method'] == 'POST' ? 1 : 0;
            $data = $item['params'];
            // 禁用成功
            $params = array(
                'account_id' => $data['account_id']
            );
            $params = json_encode($params);
            $res = Request::juhecurl($apiUrl, $params, $isPost);
            $res = json_decode($res, true);
            $re = $this->getTestResult();
            $this->assertEquals('000000', $res['code'], '账号禁用: 禁用成功');
            // 账号无效
            $params = array(
                'account_id' => ''
            );
            $params = json_encode($params);
            $res = Request::juhecurl($apiUrl, $params, $isPost);
            $res = json_decode($res, true);
            $this->assertEquals('130001', $res['code'], '账号禁用: '. $res['msg']);
            // 重复禁用
            $params = array(
                'account_id' => $data['account_id']
            );
            $params = json_encode($params);
            $res = Request::juhecurl($apiUrl, $params, $isPost);
            $res = json_decode($res, true);
            $this->assertEquals('130010', $res['code'], '账号禁用: '. $res['msg']);
        }
    }

    public function test_changePassword() {
        foreach ($this->_datas as $key => $item) {
            $apiUrl = 'http://' . $_SERVER['SERVER_NAME'] . '/' . $item['uri'] . '/changepwd';
            $isPost = $item['method'] == 'POST' ? 1 : 0;
            $data = $item['params'];
            // 密码修改成功
            $params = array(
                'account_id' => $data['account_id'],
                'pwd_old' => $data['pwd'],
                'pwd_new' => '000000',
            );
            $params = json_encode($params);
            $res = Request::juhecurl($apiUrl, $params, $isPost);
            $res = json_decode($res, true);
            $re = $this->getTestResult();
            $this->assertEquals('000000', $res['code'], '修改密码: 修改成功');
            // 账号无效
            $params = array(
                'account_id' => '',
                'pwd_old' => $data['pwd'],
                'pwd_new' => '000000',
            );
            $params = json_encode($params);
            $res = Request::juhecurl($apiUrl, $params, $isPost);
            $res = json_decode($res, true);
            $re = $this->getTestResult();
            $this->assertEquals('130001', $res['code'], '修改密码: '. $res['msg']);
            // 账号原始密码无效
            $params = array(
                'account_id' => $data['account_id'],
                'pwd_old' => '',
                'pwd_new' => '000000',
            );
            $params = json_encode($params);
            $res = Request::juhecurl($apiUrl, $params, $isPost);
            $res = json_decode($res, true);
            $re = $this->getTestResult();
            $this->assertEquals('130018', $res['code'], '修改密码: '. $res['msg']);
            // 账号原始密码无效
            $params = array(
                'account_id' => $data['account_id'],
                'pwd_old' => $data['pwd'],
                'pwd_new' => '',
            );
            $params = json_encode($params);
            $res = Request::juhecurl($apiUrl, $params, $isPost);
            $res = json_decode($res, true);
            $re = $this->getTestResult();
            $this->assertEquals('130019', $res['code'], '修改密码: '. $res['msg']);
        }
    }

    public function test_getAccountInfo() {
        foreach ($this->_datas as $key => $item) {
            $apiUrl = 'http://' . $_SERVER['SERVER_NAME'] . '/' . $item['uri'] . '/info';
            $isPost = $item['method'] == 'GET' ? 1 : 0;
            $data = $item['params'];
            // 获取账号成功
            $params = array(
                'account_id' => $data['account_id'],
            );
            $params = json_encode($params);
            $res = Request::juhecurl($apiUrl, $params, $isPost);
            $res = json_decode($res, true);
            $re = $this->getTestResult();
            $this->assertEquals('000000', $res['code'], '获取账号资料:  获取成功');
            // 账号无效
            $params = array(
                'account_id' => '',
            );
            $params = json_encode($params);
            $res = Request::juhecurl($apiUrl, $params, $isPost);
            $res = json_decode($res, true);
            $re = $this->getTestResult();
            $this->assertEquals('130001', $res['code'], '获取账号资料: '. $res['msg']);


        }
    }

    public function test_cancelAccount() {
        foreach ($this->_datas as $key => $item) {
            $apiUrl = 'http://' . $_SERVER['SERVER_NAME'] . '/' . $item['uri'] . '/cancel';
            $isPost = $item['method'] == 'POST' ? 1 : 0;
            $data = $item['params'];
            // 账号注销成功
            $params = array(
                'account_id' => $data['account_id'],
            );
            $params = json_encode($params);
            $res = Request::juhecurl($apiUrl, $params, $isPost);
            $res = json_decode($res, true);
            $re = $this->getTestResult();
            $this->assertEquals('000000', $res['code'], '账号销毁: 销毁成功');
            // 账号无效
            $params = array(
                'account_id' => ''
            );
            $params = json_encode($params);
            $res = Request::juhecurl($apiUrl, $params, $isPost);
            $res = json_decode($res, true);
            $this->assertEquals('130001', $res['code'], '账号销毁: '. $res['msg']);
            // 重复销毁
            $params = array(
                'account_id' => $data['account_id']
            );
            $params = json_encode($params);
            $res = Request::juhecurl($apiUrl, $params, $isPost);
            $res = json_decode($res, true);
            $this->assertEquals('130011', $res['code'], '账号销毁: '. $res['msg']);
        }
    }

}