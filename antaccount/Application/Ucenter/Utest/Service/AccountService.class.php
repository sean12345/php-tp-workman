<?php
/**
 * 用户账号操作模型
 * 
 * @category API
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
namespace Ucenter\Utest\Service;

use Think\UnitTest;
use \Admin\Org\Request;
use Ucenter\Model\AntNest\AccountModel;


class AccountService extends UnitTest {

    private $_datas = array();

    function index(){
        //通过自动遍历测试类的方式执行测试
        $this->run(true);
    }

    //前置操作方法    
    public function __construct() {
        $this->prepareData();
        $this->test_addAccount();
    }

    private function prepareData() {
        $dataFile = MODULE_PATH . "Utest" . DIRECTORY_SEPARATOR . "Data" . DIRECTORY_SEPARATOR . "createAccountModel.json";
        $contents = file_get_contents($dataFile);
        $this->_datas = json_decode($contents, true);
        foreach ($this->_datas as $item) {
            //按account_name和mobile清空账号数据
            $cond = array(
                'account_name' => $item['params']['account_name'],
                'mobile' => $item['params']['mobile'],
                '_logic' =>'or',
            );
            $accountIds = D('AntNest\Account', 'Model')->where($cond)->getField('account_id');
            $res = D('AntNest\Account', 'Model')->where($cond)->delete();
            $cond = array(
                'account_id' => is_array($accountIds) ? array('in', $accountIds) : $accountIds
            );
            D('AntNest\AccountLog', 'Model')->where($cond)->delete();
        }
    }

    private function test_addAccount() {
            foreach ($this->_datas as $key => $item) {
            $params = $item['params'];
            $expect = $item['responses'];
            try {
                $accountID = NULL;
                $accountID =  D('Account', 'Service')->addAccount($params);
            } catch (\Exception $e) {
                $res = array(
                    'code' => $e->getCode(),
                    'msg' => $e->getMessage(),
                    'data' => array(),
                );
            }
            if ($accountID) {
                $res = array ('account_id' => $accountID);
                $this->assertNotEmpty($accountID, '用户账号注册:注册成功,account_id='.$accountID);
                $this->_datas[$key]['params']['account_id'] = $accountID;
            } else {
                switch ($res['code']) {
                    case '130007':
                        $this->assertEquals($expect['code'], $res['code'], '用户账号注册:'.$res['msg']);
                        unset($this->_datas[$key]);
                        break;                
                    default:
                        break;
                }
            }
        }
    }

    public function test_activeAccount() {
        foreach ($this->_datas as $key => $item) {
            // 激活成功
            $accountID = $item['params']['account_id'];
            $res =  D('Account', 'Service')->activeAccount($accountID);
            $this->assertTrue($res, '用户账号激活: 激活成功');
            // 账号无效
            try {
                $accountID = '';
                $res =  D('Account', 'Service')->activeAccount($accountID);
            } catch (\Exception $e) {
                $res = array(
                    'code' => $e->getCode(),
                    'msg' => $e->getMessage(),
                    'data' => array(),
                );
                $this->assertEquals('130001', $res['code'], '用户账号激活: '. $res['msg']);
            }
            // 重复激活
            try {
                $accountID = $item['params']['account_id'];
                $res =  D('Account', 'Service')->activeAccount($accountID);
            } catch (\Exception $e) {
                $res = array(
                    'code' => $e->getCode(),
                    'msg' => $e->getMessage(),
                    'data' => array(),
                );
                $this->assertEquals('130010', $res['code'], '用户账号激活: '. $res['msg']);
            }
        }
    }

    public function test_accountLogin() {
        foreach ($this->_datas as $key => $item) {
            // 登录成功
            $accountName = $item['params']['account_name'];
            $pwd = $item['params']['pwd'];
            $accountType = $item['params']['account_type'];
            $res =  D('Account', 'Service')->accountLogin($accountName, $pwd, $accountType);
            $this->assertNotEmptyArray($res, '用户登录: 登录成功');
            $this->assertArrayHasKey('info', $res, '用户登录: 登录成功');
            // 用户名错误
            try {
                $accountName = '';
                $pwd = $item['params']['pwd'];
                $accountType = $item['params']['account_type'];
                $res =  D('Account', 'Service')->accountLogin($accountName, $pwd, $accountType);
            } catch (\Exception $e) {
                $res = array(
                    'code' => $e->getCode(),
                    'msg' => $e->getMessage(),
                    'data' => array(),
                );
                $this->assertEquals('130013', $res['code'], '用户登录: '. $res['msg']);
            }
            // 密码错误
            try {
                $accountName = $item['params']['account_name'];
                $pwd = '';
                $accountType = $item['params']['account_type'];
                $res =  D('Account', 'Service')->accountLogin($accountName, $pwd, $accountType);
            } catch (\Exception $e) {
                $res = array(
                    'code' => $e->getCode(),
                    'msg' => $e->getMessage(),
                    'data' => array(),
                );
                $this->assertEquals('130002', $res['code'], '用户登录: '. $res['msg']);
            }
            // 账号类型无效
            try {
                $accountName = $item['params']['account_name'];
                $pwd = $item['params']['pwd'];
                $accountType = '';
                $res =  D('Account', 'Service')->accountLogin($accountName, $pwd, $accountType);
            } catch (\Exception $e) {
                $res = array(
                    'code' => $e->getCode(),
                    'msg' => $e->getMessage(),
                    'data' => array(),
                );
                $this->assertEquals('130017', $res['code'], '用户登录: '. $res['msg']);
            }
        }
    }

    public function test_accountLogout() {
        foreach ($this->_datas as $key => $item) {
            // 退出登录成功
            $accountID = $item['params']['account_id'];
            $accountType = $item['params']['account_type'];
            $res =  D('Account', 'Service')->accountLogout($accountID, $accountType);
            $this->assertTrue($res, '退出登录: 退出登录成功');
            // 账号ID错误
            try {
                $accountID = '';
                $accountType = $item['params']['account_type'];
                $res =  D('Account', 'Service')->accountLogout($accountID, $accountType);
            } catch (\Exception $e) {
                $res = array(
                    'code' => $e->getCode(),
                    'msg' => $e->getMessage(),
                    'data' => array(),
                );
                $this->assertEquals('130001', $res['code'], '退出登录: '. $res['msg']);
            }
            // 账号类型错误
            try {
                $accountID = $item['params']['account_id'];
                $accountType = '';
                $res =  D('Account', 'Service')->accountLogout($accountID, $accountType);
            } catch (\Exception $e) {
                $res = array(
                    'code' => $e->getCode(),
                    'msg' => $e->getMessage(),
                    'data' => array(),
                );
                $this->assertEquals('130017', $res['code'], '退出登录: '. $res['msg']);
            }
        }
    }

    public function test_inactiveAccount() {
        foreach ($this->_datas as $key => $item) {
            // 禁用成功
            $accountID = $item['params']['account_id'];
            $res =  D('Account', 'Service')->inactiveAccount($accountID);
            $this->assertTrue($res, '账号禁用: 禁用成功');
            // 账号无效
            try {
                $accountID = '';
                $res =  D('Account', 'Service')->inactiveAccount($accountID);
            } catch (\Exception $e) {
                $res = array(
                    'code' => $e->getCode(),
                    'msg' => $e->getMessage(),
                    'data' => array(),
                );
                $this->assertEquals('130001', $res['code'], '账号禁用: '. $res['msg']);
            }
            // 重复禁用
            try {
                $accountID = $item['params']['account_id'];
                $res =  D('Account', 'Service')->inactiveAccount($accountID);
            } catch (\Exception $e) {
                $res = array(
                    'code' => $e->getCode(),
                    'msg' => $e->getMessage(),
                    'data' => array(),
                );
                $this->assertEquals('130010', $res['code'], '账号禁用: '. $res['msg']);
            }
        }
    }

    public function test_changePassword() {
        foreach ($this->_datas as $key => $item) {
            // 禁用成功
            $accountID = $item['params']['account_id'];
            $pwdOld = $item['params']['pwd'];
            $pwdNew = '123456';
            $res =  D('Account', 'Service')->changePassword($accountID, $pwdOld, $pwdNew);
            $this->assertTrue($res, '修改密码: 修改成功');
            // 账号无效
            try {
                $accountID = '';
                $pwdOld = $item['params']['account_id'];
                $pwdNew = '123456';
                $res =  D('Account', 'Service')->changePassword($accountID, $pwdOld, $pwdNew);
            } catch (\Exception $e) {
                $res = array(
                    'code' => $e->getCode(),
                    'msg' => $e->getMessage(),
                    'data' => array(),
                );
                $this->assertEquals('130001', $res['code'], '修改密码: '. $res['msg']);
            }
            // 账号原始密码无效
            try {
                $accountID = $item['params']['account_id'];
                $pwdOld = '';
                $pwdNew = '123456';
                $res =  D('Account', 'Service')->changePassword($accountID, $pwdOld, $pwdNew);
            } catch (\Exception $e) {
                $res = array(
                    'code' => $e->getCode(),
                    'msg' => $e->getMessage(),
                    'data' => array(),
                );
                $this->assertEquals('130018', $res['code'], '修改密码: '. $res['msg']);
            }
            // 账号新密码无效
            try {
                $accountID = $item['params']['account_id'];
                $pwdOld = $item['params']['pwd'];
                $pwdNew = '';
                $res =  D('Account', 'Service')->changePassword($accountID, $pwdOld, $pwdNew);
            } catch (\Exception $e) {
                $res = array(
                    'code' => $e->getCode(),
                    'msg' => $e->getMessage(),
                    'data' => array(),
                );
                $this->assertEquals('130019', $res['code'], '修改密码: '. $res['msg']);
            }
        }
    }

    public function test_getAccountInfo() {
        foreach ($this->_datas as $key => $item) {
            // 获取账号成功
            $accountID = $item['params']['account_id'];
            $res =  D('Account', 'Service')->getAccountInfo($accountID);
            $this->assertNotEmptyArray($res, '获取账号资料:  获取成功');
            // 账号无效
            try {
                $accountID = '';
                $res =  D('Account', 'Service')->getAccountInfo($accountID);
            } catch (\Exception $e) {
                $res = array(
                    'code' => $e->getCode(),
                    'msg' => $e->getMessage(),
                    'data' => array(),
                );
                $this->assertEquals('130001', $res['code'], '获取账号资料: '. $res['msg']);
            }

        }
    }

    public function test_cancelAccount() {
        foreach ($this->_datas as $key => $item) {
            // 账号注销成功
            $accountID = $item['params']['account_id'];
            $res =  D('Account', 'Service')->cancelAccount($accountID);
            $this->assertTrue($res, '账号销毁: 销毁成功');
            // 账号无效
            try {
                $accountID = '';
                $res =  D('Account', 'Service')->cancelAccount($accountID);
            } catch (\Exception $e) {
                $res = array(
                    'code' => $e->getCode(),
                    'msg' => $e->getMessage(),
                    'data' => array(),
                );
                $this->assertEquals('130001', $res['code'], '账号销毁: '. $res['msg']);
            }
            // 重复销毁
            try {
                $accountID = $item['params']['account_id'];
                $res =  D('Account', 'Service')->cancelAccount($accountID);
            } catch (\Exception $e) {
                $res = array(
                    'code' => $e->getCode(),
                    'msg' => $e->getMessage(),
                    'data' => array(),
                );
                $this->assertEquals('130011', $res['code'], '账号销毁: '. $res['msg']);
            }
        }
    }
}