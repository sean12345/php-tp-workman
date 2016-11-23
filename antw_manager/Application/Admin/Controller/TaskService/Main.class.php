<?php
/**
 * ant-nest服务管理平台
 *
 *
 * @category API
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
namespace Admin\Controller;

use Common\Controller\CommonController;
// use Think\Controller;

class AdminController extends CommonController {
    // protected $page_num = 10;

    public function index(){
        $this->assign ( 'page', 100 ); // 赋值分页输出
        $this->display(''); // 输出模板
    }

}