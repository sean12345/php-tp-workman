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
namespace Admin\Controller;

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


// try {    
// $rsa = new Rsa();
// $str = '宝贝购 ';

// //私钥加密
//     $data = $rsa->privateKeyEncode($str);
//     echo $data . '<br><br><br>';
// //公钥解密
//     $decode = $rsa->decodePrivateEncode($data);
//     echo $decode . '<br><br><br>';
// //公钥加密
//     $pdata = $rsa->publicKeyEncode('Hello World ！, 世界 你好！');
//     echo $pdata . '<br><br><br>';
// //私钥解密
//     $pdecode = $rsa->decodePublicEncode($pdata);
//     echo $pdecode . '<br><br><br>';
// } catch (Exception $exc) {
//     echo $exc->getMessage();
// }

        // $data = array(
        //     'mobile' => '15011112222',
        //     'gateway' => 'xxx',
        //     'msg_type' => '1',
        //     'msg_var' => '2',
        //     'response_code' => '10',
        //     'remark' => 'txt发斯蒂芬发到付',
        //     'createtime' => timeNow(),
        // );
        // $modelObj = D('SMS/ANT_NEST/MsgSendLog');
        // try{
        //     echo $res = $modelObj->data($data)->add();
        //     exit;
        // } catch (\Exception $e) {
        //     $modelObj = $modelObj->db(1, C('DB_ANT_NEST'), true);
        //     $res = $modelObj->data($data)->add();
        // }

        // $dbObj = new Db(C('DB_ANT_NEST'));
        // $res = $dbObj->data($data)->add();
        // $dbObj->close();

//         $mod = new BaseModel();
// $this->db(0,empty($this->connection)?$connection:$this->connection,true);

//         $modelObj = M('MsgSendLog', 'ant_', C('DB_ANT_NEST'));
//         $obj = $modelObj->db(0, C('DB_ANT_NEST'), true);
//         $res = $obj->data($data)->add();
// dump($res);        




// $res = M('MsgSendLog', 'ant_', C('DB_ANT_NEST'));
// $res->close();

// $res1 = M('MsgSendLog', 'ant_', C('DB_ANT_NEST'));
// var_dump($res1);

// var_dump($_model);
        // var_dump($res);

//         $res =  D('SMS/MsgTask', 'Service')->addNotifyMsgTask('15029911786', '1', array("username"=>"sean","password"=>"111111"));
//         // $taskCount =  D('SMS/MsgTask', 'Service')->getNotifyTaskCount();
//         $taskList =  D('SMS/MsgTask', 'Service')->getNotifyTaskList();
//         // $taskNow =  D('SMS/MsgTask', 'Service')->checkoutNotifyTask();
//         // $taskNow1 =  D('SMS/MsgTask', 'Service')->checkoutNotifyTask();
// dump($res);
// dump($taskCount);
// dump($taskList);
// dump($taskNow);
// dump($taskNow1);
// exit;
// 
        $fileName = I('get.doc_name', 'readme') . '.md';
        $moduleName = I('get.m_from', MODULE_NAME);
        import("Common.Org.Parsedown");
        $Parsedown = new \Common\ORG\Parsedown();
        $fileAddr = APP_PATH . DIRECTORY_SEPARATOR . $moduleName . DIRECTORY_SEPARATOR . 'Doc' . DIRECTORY_SEPARATOR . $fileName;
        $content = file_get_contents($fileAddr);
        $content =  $Parsedown->text($content);
        if (empty($content)) {
            $this->_empty();
        }
        $this->assign('content', $content);
        layout(false);
        $this->display('Doc/show_nolayout');
        // $this->display('Doc/show');
     }

}