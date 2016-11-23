<?php
namespace SMS\Service;

use Base\ExceptionHandler;
use Base\BaseService;
use \Common\Org\PhpRedis;

class MsgGateWayService extends BaseService{
    private $Redis;
    private $mob_code_key = 'mob_code_';

    public function __construct() {
        $this->Redis = new PhpRedis();
    }

    Protected $autoCheckFields = false;

    /**
     * 发送短信通知
     * 
     * @param  string  $mobile  短信接收人电话
     * @param  int  $number  短信自定义类型
     * @param  array  $params  短信模块参数
     * 
     * @return json
     */
    public function msgSend($mobile='', $number='', $params=array())
    {
        if (empty($mobile)) {
            ExceptionHandler::make_throw('0006');
        }
        if (!validatePhone($mobile)) {
            ExceptionHandler::make_throw('0006');
        }
        $config =  C('SMS_API.COMMON');
        $diff_key = array_diff_key($config['VAR_LIST'][$number], $params);
        if (count($diff_key) > 0) {
            ExceptionHandler::make_throw('0003');
        }
        $res = D('SMS/MsgTask', 'Service')->addNotifyMsgTask($mobile, $number, $params);
        return $res;
    }

    /**
     * 发送短信验证码
     * 
     * @param  string  $mobile  短信接收人电话
     * @param  int  $number  短信自定义类型
     * 
     * @return json
     */
    public function codeSend($mobile='', $number='')
    {
        if (empty($mobile)) {
            ExceptionHandler::make_throw('0006');
        }
        if (!validatePhone($mobile)) {
            ExceptionHandler::make_throw('0006');
        }
        //控制手机号验证码每日配额
        $msgLimit = $this->Redis->get($this->mob_code_key . 'num_' . $mobile);
        if ($msgLimit) {
            $limitData = json_decode($msgLimit, true);
            $time_60s = time() - $limitData['time'];
            if ($time_60s < 30) {
                ExceptionHandler::make_throw('0090');
            }
            if ($limitData['num'] > 100) {
                ExceptionHandler::make_throw('0088');
            }
            $num = $limitData['num'] + 1;
        } else {
            $num = 1;
        }
        $ver_code = generateCode(6);
        $rs = D('SMS/MsgTask', 'Service')->addVerifyMsgTask($mobile, $number, $ver_code);
        $params = array(
                                 'num' => $num, 
                                 'time' => time()
                                 );
        $diff_time = strtotime('tomorrow') - time();
        $this->Redis->set($this->mob_code_key . 'num_' . $mobile, json_encode($params), $diff_time);
        $params_code = array(
            'code' => $ver_code,
            'number' => $number
        );
        $expire = 60*10; //验证码有效期10分钟
        $this->Redis->set($this->mob_code_key . $mobile, json_encode($params_code), $expire);
        $res = false;
        if ($rs) {
            $res = array(
                            'ver_code' => $ver_code
                        );
        }
        return $res;
    }

    /**
     * 校验短信验证码
     * 
     * @param  int  $number  短信自定义类型
     * @param  string  $mobile  短信接收人电话
     * @param  string  $verCode 短信验证码
     * 
     * @return boolean
     */
    public function verifyCode($number='', $mobile='', $verCode='')
    {
        if (empty($mobile)) {
            ExceptionHandler::make_throw('0006');
        }
        if (!validatePhone($mobile)) {
            ExceptionHandler::make_throw('0006');
        }
        if (!validateAuthCode($verCode)) {
            ExceptionHandler::make_throw('0084');
        }
        $msgInfo = $this->Redis->get($this->mob_code_key . $mobile);
        $msgInfo = json_decode($msgInfo, true);
        if (!$msgInfo['code']) {
            ExceptionHandler::make_throw('0086');
        }
        if ($msgInfo['code'] != $verCode) {
            ExceptionHandler::make_throw('0086');
        }
        if ($msgInfo['number'] != $number) {
            ExceptionHandler::make_throw('0086');
        }
        return true;
    }

    /**
     * 验证生成token
     * @param string $info "{uuid:$uuid,type:$type,expire:$expire}"
     * @return string
     */
    public function gen_token($info) {
        return think_encrypt($info);
    }

    /**
     * 验证解析token
     * @param type $token
     * @return array $mob_token
     */
    public function get_info_by_token($token) {
        $mob_token = json_decode(think_decrypt($token), true);
        $left_time = time() - $mob_token['expire'];
        if ($left_time > 0) {
            AuctionException::make_throw('0089');
        }
        return $mob_token;
    }
}