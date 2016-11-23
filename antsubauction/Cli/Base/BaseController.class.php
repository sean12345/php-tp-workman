<?php
/**
 * ant-nest基础控制器
 *
 * 提供控制层功能处理
 *
 * @category API
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
namespace Base;

use Think\Controller\RestController;

class BaseController extends RestController {
    public function _empty($name)
    {        
        echo "调用-->公共空操作方法";
    }
    public function _before_index(){
        // echo "调用-->公共预处理方法";
    }

    
}