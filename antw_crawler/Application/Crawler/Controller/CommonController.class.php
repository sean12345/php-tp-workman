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
namespace SMS\Controller;

use Base\Controller;

class CommonController extends Controller {
    protected $allowMethod = array('post');

    protected $allowType = array('json');

    protected $defaultMethod = 'post';

    protected $defaultType = 'json';

    protected $allowOutputType = array(
            'xml' => 'application/xml',
            'json' => 'application/json',
            'html' => 'text/html',
    );

    // public function __construct() 
    // {
    //     $this->checkApiToken();
    // }

    public function _initialize() {

    }

    public function _before_index(){
    }
}