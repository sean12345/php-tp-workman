<?php
/**
 * AN蚁巢控制台登录控制
 *
 */
namespace Admin\Service;

use Base\ExceptionHandler;
use Base\BaseService;
use Common\Org\PhpRedis;

class LoginService extends CommonService{
    private $Redis;
    private $_notifyTaskListKey = 'list_msg_notifytask';
    private $_verifyTaskListKey = 'list_msg_verifytask';
    Protected $autoCheckFields = false;

    public function __construct() {
        $this->Redis = new PhpRedis();
    }

    /**
     * AN蚁巢控制台登录
     * 
     * @param  string   $userName
     * @param  string   $pwd
     * 
     * @return mix
     */
    public function checkLogin($userName='', $pwd='') {
            $res = false;
             if (!$userName) {
                ExceptionHandler::make_throw('0002');
             }
             if (!$pwd) {
                ExceptionHandler::make_throw('0003');
             }
             $authors = C('AUTHOR_CONSOLE');
             if (isset($authors[$userName])) {
                if ($authors[$userName]['pwd'] == $pwd) {
                    // $_SESSION['username'] = $row['username'];
                    // $_SESSION['username'] = $row['username'];
                    // session(array('user_name'=>$userName,'expire'=>3600));
                    session('user_name', $userName);
                    $res = true;
                } elseif ($authors[$userName]['status'] != 1) {
                    ExceptionHandler::make_throw('0005'); // 账号禁用
                } else {
                    ExceptionHandler::make_throw('0004'); // 密码错误
                }
             } else {
                ExceptionHandler::make_throw('0004'); // 账号不存在
             }
             return $res;
    }

}