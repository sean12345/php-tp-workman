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

use Base\ExceptionHandler;
use Base\BaseModel;

class AdminController extends CommonController {

    public function index() {
        $this->isLogin();
        $this->display('index');
    }

    public function login() {
        if (IS_POST) {
                $userName = I('post.user_name', '');
                $pwd = I('post.pwd', '');
                try {
                    $res = D('Login', 'Service')->checkLogin($userName, $pwd);
                    if ($res) {
                        // $this->success('登录成功','/admin/main');
                        $this->redirect('/admin/main');
                    }
                } catch (\Exception $e) {
                    $this->assign('code', $e->getCode());
                    $msg = $e->getMessage();
                    $this->assign('msg', $e->getMessage());
                    layout(false);
                    $this->display('login');
                }
        } else {
                layout(false);
                $this->display('login');
        }
    }

    public function logout() {
        session('user_name', null);
        $this->redirect('/admin/login');
    }

}