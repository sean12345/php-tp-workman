<?php
/**
 * 账号操作日志
 *
 * @category API
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
namespace Ucenter\Utest\Controller;

use Think\UnitTest;
use \Admin\Org\Request;

class AccountLogController extends UnitTest {

    private $_datas = array();

    function index(){
        //通过自动遍历测试类的方式执行测试
        $this->run(true);
    }

    //前置操作方法    
    public function __construct() {
        // $this->prepareData();
        // $this->test_registAccount();
    }


}