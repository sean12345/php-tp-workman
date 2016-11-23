<?php
/**
 * 账号操作日志
 *
 * @category API
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
namespace Ucenter\Utest\Service;

use Think\UnitTest;
use \Admin\Org\Request;

class AccountLogService extends UnitTest {

    private $_datas = array();

    function index(){
        //通过自动遍历测试类的方式执行测试
        $this->run(true);
    }

    //前置操作方法    
    public function __construct() {
        $this->prepareData();
        $this->test_accountOptionLog();
    }

    private function prepareData() {
        $dataFile = MODULE_PATH . "Utest" . DIRECTORY_SEPARATOR . "Data" . DIRECTORY_SEPARATOR . "createAccountLogModel.json";
        $contents = file_get_contents($dataFile);
        $this->_datas = json_decode($contents, true);
        foreach ($this->_datas as $item) {
            if ($item['params']['account_id']) {
                $cond = array(
                    'account_id' => $item['params']['account_id'],
                );
                D('AntNest\AccountLog', 'Model')->where($cond)->delete();
            }
        }
    }

    private function test_accountOptionLog() {
            foreach ($this->_datas as $key => $item) {
            $params = $item['params'];
            $expect = $item['responses'];
            try {
                $logID = NULL;
                $logID =  D('AccountLog', 'Service')->accountOptionLog($params);
            } catch (\Exception $e) {
                $res = array(
                    'code' => $e->getCode(),
                    'msg' => $e->getMessage(),
                    'data' => array(),
                );
            }
            if ($logID) {
                $this->assertNotEmpty($logID, '操作日志: 记录成功,log_id='.$logID);
                $this->_datas[$key]['params']['log_id'] = $logID;
            } else {
                switch ($res['code']) {
                    case '130007':
                        $this->assertEquals($expect['code'], $res['code'], '操作日志: '.$res['msg']);
                        unset($this->_datas[$key]);
                        break;                
                    default:
                        break;
                }
            }
        }
    }

    public function test_getLogList() {
        foreach ($this->_datas as $key => $item) {
            // 获取账号成功
            $bgnTime=''; 
            $endTime=''; 
            $pageNum=1; 
            $pageSep=10;
            $res =  D('AccountLog', 'Service')->getLogList($bgnTime, $endTime, $pageNum, $pageSep);
            $this->assertNotEmptyArray($res, '获取账号资料:  获取成功');
        }
    }

}