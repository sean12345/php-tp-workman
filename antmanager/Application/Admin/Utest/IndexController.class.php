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
namespace SMS\Controller;

use Think\Controller\RestController;

class IndexController extends RestController {

    protected $allowMethod = array('get','post','put','delete' ,'custom');

    protected $allowType = array('html', 'xml', 'json');

    public function index(){
            $apiList =  array(
                    'smg_get' => 'http://local.api.antnest.clcw.com.cn/sms/'
            );
            echo "<pre>";
            print_r($apiList);
            echo "</pre>";
     }

    /**
     * 获取短信验证码
     *
     * @example #curl -H "Accept:application/json" http://local.api.antnest.clcw.com.cn/sms/index/read -X PUT
     * @return [type] [description]
     */
    public function verificationsms_json(){
        echo "read_default_get_json";
    }
    
    //get
    public function read_get_json(){
        echo "read_get_json";
    }
    
    //delete
    public function read_delete_json(){
        echo "read_delete_json";
    }
    
    //put/update
    public function read_put_json(){
        echo "read_put_json";
    }
    
    //get
    public function read_post_json(){
        echo "read_post_json";
    }
    
    //custom
    public function read_custom_json(){
        echo "read_custom_json";
    }
}