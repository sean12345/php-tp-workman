<?php
/**
 * API 静态资源
 *
 *
 * @category API
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
namespace Auction\Controller;

use Base\ExceptionHandler;
use Base\BaseModel;
use Common\Org\Rsa;

class StaticController extends CommonController {

    protected $allowMethod = array('get');

    protected $allowType = array('html');

    public function pub(){
        echo "静态资源";
     }

    public function doc(){        
        $fileName = I('get.doc_name', 'readme') . '.md';
        $moduleName = I('get.m_from', MODULE_NAME);
        import("Common.Org.Parsedown");
        $parsedown = new \Common\ORG\Parsedown();
        $fileAddr = APP_PATH . DIRECTORY_SEPARATOR . $moduleName . DIRECTORY_SEPARATOR . 'Doc' . DIRECTORY_SEPARATOR . $fileName;
        $content = file_get_contents($fileAddr);
        $content =  $parsedown->text($content);
        if (empty($content)) {
            $this->_empty();
        }
        $this->assign('content', $content);
        layout(false);
        $this->display('Doc/show_nolayout');
        // $this->display('Doc/show');
     }

}