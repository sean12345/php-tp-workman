<?php
/**
 * 短信验证服务
 *
 * 提供获取验证码、发送验证码、审核验证码等功能
 *
 * @category API
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
namespace Utest\Controller;
use Think\UnitTest;

  /** 
   *   调用方法： 
   *   1. http://localhost/PROJECT_NAME/index.php?m=Test  自动执行全部测试文件 
   *   2. http://localhost/PROJECT_NAME/index.php?m=Test&controller=XXX  自动执行参数crontroller指定的文件 
   */ 
class IndexController extends UnitTest {
    function index(){
        //通过自动遍历测试类的方式执行测试
        $this->run(true);
    }
}