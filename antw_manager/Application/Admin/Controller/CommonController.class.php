<?php
/**
 * ant-nest服务管理平台
 *
 *
 * @category Controller
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
namespace Admin\Controller;

use Base\ExceptionHandler;
use Base\Controller;

class CommonController extends Controller {
        protected $page_num = 10;

        public function _initialize() {

        }

        /**
        * 判断当前是否已经登录
        * 
        * @return mix
        */
        public function isLogin() {
            $res = false;
            if (session('?user_name')) {
                $res = true;
            } else {
                $this->error('请先登录系统', '/admin/login', 3);
            }
            return $res;
        }

}