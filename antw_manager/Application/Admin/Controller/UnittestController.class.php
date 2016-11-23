<?php
/**
 * 接口短语测试
 *
 * @category API
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */

/** 
*   调用方法： 
*   1. http://localhost/PROJECT_NAME/index.php?m=Test  自动执行全部测试文件 
*   2. http://localhost/PROJECT_NAME/index.php?m=Test&controller=XXX  自动执行参数crontroller指定的文件 
*/ 
namespace Admin\Controller;

use Think\UnitTest;
use Base\ExceptionHandler;
use SMS\Utest\Controller\IndexController;

class UnittestController extends UnitTest {
    function index(){
        // R('Application://SMS/Static/index', array('is_fetch'=>1));
        $content = R('SMS/Unittest/index', array('is_fetch'=>1));

        $this->assign('content', $content);
        $this->display('Unittest/show');
        // dump($res);
        // exit;

        // //通过自动遍历测试类的方式执行测试
        // // $this->run(true);

        // $isFetch = I('get.is_fetch', 0);

        // $unitTestRegister = array(
        //     'SMS\Utest\Controller\IndexController',

        //     'SMS\Utest\Service\MsgGateWayService',
        //     'SMS\Utest\Service\MsgLogService',
        // );

        // $this->setController( $unitTestRegister );
        // $this->run(false, $isFetch);
    }
 
}