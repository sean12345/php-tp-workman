<?php
namespace SMS\Service;

use Base\ExceptionHandler;
use Base\BaseService;
use SMS\Service\MsgGateWay\Extension\MsgFactory;
use \Common\Org\PhpRedis;

class MsgGateWayService extends BaseService{
    private $Redis;
    private $mob_code_key = 'mob_code_';

    public function __construct() {
        $this->Redis = new PhpRedis();
    }

    Protected $autoCheckFields = false;

    /**
     * 获取当前正在使用的网关
     * 
     * @return mix
     */
    public function getCurrentGateWayName() {
        $res = false;
        $mod = D('SMS/AntNest/MsgGateway', 'Model');
        $res = $mod->scope('gateway_current')->getField('gateway_name');
        return $res;
    }

    /**
     * 实时发送短信
     * 
     * @param  string  $mobile  短信接收人电话
     * @param  int  $number  短信自定义类型
     * @param  array  $params  短信模块参数
     * @param  string  $gateWayName  短信平台名称,(默认取配置项里的第一个)
     * 
     * @return mix
     */
    public function msgSendActual($mobile='', $number='', $params=array(), $gateWayName='')
    {
        if (empty($mobile)) {
            ExceptionHandler::make_throw('0006');
        }
        if (!validatePhone($mobile)) {
            ExceptionHandler::make_throw('0006');
        }

        if (!$gateWayName) {
            $gateWayList = MsgFactory::getMsgGateWayList();
            foreach ($gateWayList as $gateWayName) {
                $res = $this->doMsgSend($gateWayName, $params);
                if ($res) break;
            }
        } else {            
            $res = $this->doMsgSend($gateWayName, $params);
        }
        return $res;
    }

    /**
     * 短信发送
     * 
     * @param  string  $gateWayName
     * @param  array  $taskContent
     * 
     * @return mix
     */
    private function doMsgSend($gateWayName='', $taskContent=array())
    {
            $obj = MsgFactory::Create($gateWayName);
            $res = $obj->msgSend($taskContent['appkey'], $taskContent['mobile'], $taskContent['number'], $taskContent['request_time'], $taskContent['content_params']);
            return $res;
    }

    /**
     * 发送短信通知
     * 
     * @param  string  $mobile  短信接收人电话
     * @param  int  $number  短信自定义类型
     * @param  array  $params  短信模块参数
     * @param  string  $gateWayName  短信平台名称,(默认取配置项里的第一个)
     * 
     * @return json
     */
    public function msgSend($mobile='', $number='', $params=array(), $gateWayName='')
    {
        if (empty($mobile)) {
            ExceptionHandler::make_throw('0006');
        }
        if (!validatePhone($mobile)) {
            ExceptionHandler::make_throw('0006');
        }
        $res = D('SMS/MsgTask', 'Service')->addNotifyMsgTask($mobile, $number, $params);
        return $res;
    }

    /**
     * 发送短信验证码
     * 
     * @param  string  $mobile  短信接收人电话
     * @param  int  $number  短信自定义类型
     * @param  string  $gateWayName  短信平台名称,(默认取配置项里的第一个)
     * 
     * @return json
     */
    public function codeSend($mobile='', $number='', $gateWayName='')
    {
        if (empty($mobile)) {
            ExceptionHandler::make_throw('0006');
        }
        if (!validatePhone($mobile)) {
            ExceptionHandler::make_throw('0006');
        }
        //控制手机号验证码每日配额
        $quota = $this->Redis->get($this->mob_code_key . 'num_' . $mobile);
        if ($quota) {
            $quota_data = json_decode($quota, true);
            $time_60s = time() - $quota_data['time'];
            if ($time_60s < 60) {
                ExceptionHandler::make_throw('0090');
            }
            if ($quota_data['num'] > 10) {
                ExceptionHandler::make_throw('0088');
            }
            $num = $quota_data['num'] + 1;
        } else {
            $num = 1;
        }
        $res = D('SMS/MsgTask', 'Service')->addVerifyMsgTask($mobile, $number);
        $expire = 60 * 30;
        $params = array('num' => $num, 'time' => time());
        $diff_time = strtotime('tomorrow') - time();
        if ($diff_time > 0) {
            $this->Redis->set($this->mob_code_key . 'num_' . $mobile, json_encode($params), $diff_time);
        } else {
            $this->Redis->del($this->mob_code_key . 'num_' . $mobile);
        }
        $params_code = array(
            'code' => $mob_code,
            'number' => $number
        );
        $this->Redis->set($this->mob_code_key . $mobile, json_encode($params_code), $expire);
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
        $code = $this->Redis->get($this->mob_code_key . $mobile);
        $code = json_decode($code, true);
        if (!$code['code']) {
            ExceptionHandler::make_throw('0086');
        }
        if ($code['code'] != $verCode) {
            ExceptionHandler::make_throw('0086');
        }
        if ($code['number'] != $number) {
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